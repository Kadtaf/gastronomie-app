<?php

namespace App\Classes\Controllers;

use App\Classes\Repositories\RecipeRepository;
use App\Classes\Repositories\IngredientRepository;
use App\Classes\Repositories\CategoryRepository;
use App\Classes\Repositories\StepRepository;
use App\Classes\Entities\Recipe;
use App\Classes\Entities\Step;
use App\Classes\Entities\Ingredient;
use App\Classes\Core\Upload;
use DateTimeImmutable;
use App\Classes\Core\Flash;

class RecipeController extends AbstractController
{
    private RecipeRepository $recipeRepository;
    private CategoryRepository $categoryRepository;
    private StepRepository $stepRepository;
    private IngredientRepository $ingredientRepository;

    public function __construct()
    {
        $this->recipeRepository = new RecipeRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->stepRepository = new StepRepository();
        $this->ingredientRepository = new IngredientRepository();
    }

    public function index(): void
    {
        // Filtres GET
        $filters = [
            'category_id' => $_GET['category'] ?? null,
            'difficulty'  => $_GET['difficulty'] ?? null,
            'duration'    => $_GET['duration'] ?? null,

        ];

        // Pagination
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 8;
        $offset = ($page - 1) * $limit;

        // Récupération des recettes filtrées
        $recipes = $this->recipeRepository->findWithFilters($filters, $limit, $offset);

        // Total pour pagination
        $total = $this->recipeRepository->countWithFilters($filters);
        $totalPages = max(1, ceil($total / $limit));

        // Catégories pour le filtre
        $categories = $this->categoryRepository->findAllCategories();

        // Vue
        $this->renderView('Recipes/index', [
            'recipes'     => $recipes,
            'categories'  => $categories,
            'filters'     => $filters,
            'page'        => $page,
            'totalPages'  => $totalPages
        ], layout: 'main');
    }

    public function add(): void
    {
        $categories = $this->categoryRepository->findAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->renderView('Recipes/add', [
                'categories' => $categories
            ], layout: 'main');
            return;
        }

        // Validation
        $errors = $this->validateRecipeForm($_POST, $_FILES);

        if (!empty($errors)) {
            Flash::add('error', 'Veuillez corriger les erreurs du formulaire.');

            $this->renderView('Recipes/add', [
                'errors' => $errors,
                'categories' => $categories,
                'old' => $_POST
            ], layout: 'main');
            return;
        }

        // Upload image
        $imagePath = Upload::moveFile($_FILES['img']);

        // Create recipe
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $recipe = new Recipe();
        $recipe->setTitle(strip_tags($_POST['title']))
                ->setDescription(strip_tags($_POST['description']))
                ->setDuration((int) $_POST['duration'])
                ->setFilePathImg($imagePath)
                ->setUserId($_SESSION['user']['id'] ?? 1)  // Récupérer depuis la session
                ->setCategoryId((int) $_POST['categories'])
                ->setCreatedAt($now)
                ->setUpdatedAt($now)
                ->setDifficulty($_POST['difficulty']);

        $recipeId = $this->recipeRepository->insertRecipe($recipe);

        // Steps
        foreach ($this->extractElements($_POST, 'step') as $stp) {
            $step = new Step();
            $step->setOrderStep((int) $stp['order_step'])
                ->setDescription(strip_tags($stp['description_step']))
                ->setRecipeId($recipeId);
            $this->stepRepository->insertStep($step);
        }

        // Ingredients
        foreach ($this->extractElements($_POST, 'ingredient') as $ing) {

            // 1) Créer l’ingrédient
            $ingredient = new Ingredient();
            $ingredient->setName(strip_tags($ing['name_ingredient']))
                    ->setQuantity((float) $ing['quantity_ingredient'])
                    ->setUnity(strip_tags($ing['unity_ingredient']));

            // 2) Insérer dans la table ingredient
            $ingredientId = $this->ingredientRepository->insertIngredient($ingredient);

            // 3) Lier à la recette dans ingredient_recipe
            $this->ingredientRepository->attachToRecipe($ingredientId, $recipeId);
        }

        Flash::add('success', 'Recette créée avec succès.');
        $this->redirect('/recipe/index');
    }

    private function validateRecipeForm(array $post, array $files): array
    {
        $errors = [];

        // Champs simples obligatoires
        $required = [
            'title',
            'description',
            'duration',
            'categories',
            'difficulty'
        ];

        foreach ($required as $field) {
            if (empty($post[$field])) {
                $errors[$field] = "Le champ $field est obligatoire.";
            }
        }

        // Validation numérique
        if (!empty($post['duration']) && !ctype_digit($post['duration'])) {
            $errors['duration'] = "La durée doit être un nombre entier.";
        }

        // Validation des ingrédients
        if (empty($post['name_ingredient']) || !is_array($post['name_ingredient'])) {
            $errors['ingredient'] = "Vous devez ajouter au moins un ingrédient.";
        } else {
            foreach ($post['name_ingredient'] as $i => $name) {
                if (empty($name)) {
                    $errors["ingredient_$i"] = "Le nom de l’ingrédient #".($i+1)." est obligatoire.";
                }

                if (empty($post['quantity_ingredient'][$i]) || !is_numeric($post['quantity_ingredient'][$i])) {
                    $errors["quantity_$i"] = "La quantité de l’ingrédient #".($i+1)." doit être un nombre.";
                }

                if (empty($post['unity_ingredient'][$i])) {
                    $errors["unity_$i"] = "L’unité de l’ingrédient #".($i+1)." est obligatoire.";
                }
            }
        }

        // Validation des étapes
        if (empty($post['order_step']) || !is_array($post['order_step'])) {
            $errors['step'] = "Vous devez ajouter au moins une étape.";
        } else {
            foreach ($post['order_step'] as $i => $order) {
                if (empty($order) || !ctype_digit($order)) {
                    $errors["order_step_$i"] = "L’ordre de l’étape #".($i+1)." doit être un nombre.";
                }

                if (empty($post['description_step'][$i])) {
                    $errors["description_step_$i"] = "La description de l’étape #".($i+1)." est obligatoire.";
                }
            }
        }

        // Validation de l’image
        if (empty($files['img']['size'])) {
            $errors['img'] = "L'image est obligatoire.";
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($files['img']['type'], $allowedTypes)) {
                $errors['img'] = "L'image doit être au format JPG, PNG ou WEBP.";
            }

            if ($files['img']['size'] > 3 * 1024 * 1024) { // 3 Mo
                $errors['img'] = "L'image ne doit pas dépasser 3 Mo.";
            }
        }

        return $errors;
    }

    private function extractElements(array $data, string $type): array
    {
        $map = [
            'ingredient' => ['name_ingredient', 'quantity_ingredient', 'unity_ingredient'],
            'step' => ['order_step', 'description_step']
        ];

        $keys = $map[$type];
        $count = count($data[$keys[0]]);

        $elements = [];

        for ($i = 0; $i < $count; $i++) {
            $element = [];
            foreach ($keys as $key) {
                $element[$key] = $data[$key][$i];
            }
            $elements[] = $element;
        }

        return $elements;
    }

    public function show(int $id): void
    {
        $recipe = $this->recipeRepository->findRecipe($id);
        $ingredients = $this->ingredientRepository->findByRecipe($id);
        $steps = $this->stepRepository->findByRecipe($id);

        $this->renderView('Recipes/show', [
            'recipe' => $recipe,
            'ingredients' => $ingredients,
            'steps' => $steps
        ], layout: 'main');
    }
}
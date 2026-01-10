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
        $recipes = $this->recipeRepository->findAllRecipes();

        $this->renderView('Recipes/index', [
            'recipes' => $recipes
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

        $recipe = new Recipe(
            strip_tags($_POST['title']),
            strip_tags($_POST['description']),
            (int) $_POST['duration'],
            $imagePath,
            1, // TODO: remplacer par $_SESSION['user']['id']
            (int) $_POST['categories'],
            $now,
            $now
        );

        $recipeId = $this->recipeRepository->insertRecipe($recipe);

        // Steps
        foreach ($this->extractElements($_POST, 'step') as $stp) {
            $step = new Step(
                (int) $stp['order_step'],
                strip_tags($stp['description_step']),
                $recipeId
            );
            $this->stepRepository->insertStep($step);
        }

        // Ingredients
        foreach ($this->extractElements($_POST, 'ingredient') as $ing) {
            $ingredient = new Ingredient(
                strip_tags($ing['name_ingredient']),
                (float) $ing['quantity_ingredient'],
                strip_tags($ing['unity_ingredient']),
                $recipeId
            );
            $this->ingredientRepository->insertIngredient($ingredient);
        }

        $this->redirect('/recipe/index');
    }

    private function validateRecipeForm(array $post, array $files): array
    {
        $errors = [];
        $required = [
            'title', 'description', 'duration',
            'name_ingredient', 'quantity_ingredient', 'unity_ingredient',
            'order_step', 'description_step', 'categories'
        ];

        foreach ($required as $field) {
            if (empty($post[$field])) {
                $errors[$field] = "Le champ $field doit être renseigné.";
            }
        }

        if (empty($files['img']['size'])) {
            $errors['img'] = "L'image est obligatoire.";
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
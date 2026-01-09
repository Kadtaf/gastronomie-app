<?php
namespace App\Classes\Controllers;

use App\Classes\Repositories\RecipeRepository;
use App\Classes\Repositories\IngredientRepository;
use App\Classes\Repositories\CategoryRepository;
use App\Classes\Repositories\StepRepository;
use App\Classes\Controllers\AbstractController;
use App\Classes\Entities\Recipe;
use App\Classes\Entities\Step;
use App\Classes\Entities\Ingredient;
use App\Classes\Core\Upload;
use App\Classes\Core\Form;
use DateTimeImmutable;

class RecipeController extends AbstractController
{
    public function index()
    {
        $recipeRepository = new RecipeRepository();
        $recipes = $recipeRepository->findAllRecipes();

        return $this->renderView("Recipes/index", [
            "recipes" => $recipes
        ]);
    }

    public function add()
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAllCategories();

        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $this->renderView("Recipes/add", [
                "categories" => $categories
            ]);
        }

        // Validation
        $errors = [];
        $required = [
            "title", "description", "duration",
            "name_ingredient", "quantity_ingredient", "unity_ingredient",
            "order_step", "description_step", "categories"
        ];

        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = "Le champ $field doit être renseigné.";
            }
        }

        if ($_FILES["img"]["size"] === 0) {
            $errors["img"] = "L'image est obligatoire.";
        }

        if (!empty($errors)) {
            return $this->renderView("Recipes/add", [
                "errors" => $errors,
                "categories" => $categories
            ]);
        }

        // Création de la recette
        $file_path_img = Upload::moveFile($_FILES["img"]);
        $date = new DateTimeImmutable();

        $recipe = new Recipe(
            strip_tags($_POST["title"]),
            strip_tags($_POST["description"]),
            strip_tags($_POST["duration"]),
            $file_path_img,
            1, // user_id
            $date->format("Y-m-d H:i:s"),
            $date->format("Y-m-d H:i:s")
        );

        $recipeRepository = new RecipeRepository();
        $recipeId = $recipeRepository->insertRecipe($recipe);

        // Ajout des étapes
        $stepRepository = new StepRepository();
        $steps = $this->getElements($_POST, "step");

        foreach ($steps as $stp) {
            $step = new Step(
                $stp["order_step"],
                $stp["description_step"],
                $recipeId
            );
            $stepRepository->insertStep($step);
        }

        // Ajout des ingrédients
        $ingredientRepository = new IngredientRepository();
        $ingredients = $this->getElements($_POST, "ingredient");

        foreach ($ingredients as $ing) {
            $ingredient = new Ingredient(
                $ing["name_ingredient"],
                $ing["quantity_ingredient"],
                $ing["unity_ingredient"],
                $recipeId
            );
            $ingredientRepository->insertIngredient($ingredient);
        }

        return $this->redirect("/recipe/index");
    }

    private function getElements(array $tab, string $name): array
    {
        $elements = [];
        $keys = [];

        if ($name === "ingredient") {
            $keys = ["name_ingredient", "quantity_ingredient", "unity_ingredient"];
        }

        if ($name === "step") {
            $keys = ["order_step", "description_step"];
        }

        $field = $keys[0];
        $count = count($tab[$field]);

        for ($i = 0; $i < $count; $i++) {
            $element = [];
            foreach ($keys as $key) {
                $element[$key] = $tab[$key][$i];
            }
            $elements[] = $element;
        }

        return $elements;
    }

    public function show(int $id)
    {
        $recipeRepository = new RecipeRepository();
        $ingredientRepository = new IngredientRepository();
        $stepRepository = new StepRepository();

        $recipe = $recipeRepository->findRecipe($id);
        $ingredients = $ingredientRepository->findByRecipe($id);
        $steps = $stepRepository->findByRecipe($id);

        return $this->renderView("Recipes/show", [
            "recipe" => $recipe,
            "ingredients" => $ingredients,
            "steps" => $steps
        ]);
    }
}
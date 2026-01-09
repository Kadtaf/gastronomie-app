<?php
namespace App\Classes\Controllers;

use App\Classes\Controllers\AbstractController;
use App\Classes\Repositories\CategoryRepository;
use App\Classes\Entities\Category;

class CategoryController extends AbstractController
{
    public function index()
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAllCategories();

        return $this->renderView("Categories/index", [
            "categories" => $categories
        ]);
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $this->renderView("Categories/add");
        }

        $errors = [];

        if (empty($_POST["name"])) {
            $errors["name"] = "Le nom de la catégorie est obligatoire.";
        }

        if (!empty($errors)) {
            return $this->renderView("Categories/add", [
                "errors" => $errors
            ]);
        }

        $category = new Category(strip_tags($_POST["name"]));

        $categoryRepository = new CategoryRepository();
        $categoryRepository->insertCategory($category);

        return $this->redirect("/category/index");
    }
}
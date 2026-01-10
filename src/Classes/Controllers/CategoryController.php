<?php

namespace App\Classes\Controllers;

use App\Classes\Repositories\CategoryRepository;
use App\Classes\Entities\Category;

class CategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function index(): void
    {
        $categories = $this->categoryRepository->findAllCategories();

        $this->renderView('Categories/index', [
            'categories' => $categories
        ], layout: 'main');
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->renderView('Categories/add', [], layout: 'main');
            return;
        }

        $errors = [];

        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            $errors['name'] = 'Le nom de la catégorie est obligatoire.';
        }

        if (!empty($errors)) {
            $this->renderView('Categories/add', [
                'errors' => $errors,
                'old' => ['name' => $name]
            ], layout: 'main');
            return;
        }

        $category = new Category(strip_tags($name));
        $this->categoryRepository->insertCategory($category);

        $this->redirect('/category/index');
    }
}
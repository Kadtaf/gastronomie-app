<?php

namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;
use App\Classes\Entities\Category;

class CategoryRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'category'; // ou 'categories' selon ta DB
    }

    public function insertCategory(Category $category): int
    {
        $data = [
            'name' => $category->getName(),
        ];

        return $this->insert($data);
    }

    public function updateCategory(Category $category): bool
    {
        $data = [
            'name' => $category->getName(),
        ];

        return $this->update($category->getId(), $data);
    }

    public function deleteCategory(int $id): bool
    {
        return $this->delete($id);
    }

    public function findCategory(int $id): ?Category
    {
        $data = parent::find($id);
        return $data ? $this->hydrate(Category::class, $data) : null;
    }

    public function findAllCategories(): array
    {
        $rows = parent::findAll();
        return array_map(fn ($row) => $this->hydrate(Category::class, $row), $rows);
    }

    public function findByName(string $name): ?Category
    {
        $rows = $this->findBy(['name' => $name]);

        if (empty($rows)) {
            return null;
        }

        return $this->hydrate(Category::class, $rows[0]);
    }
}
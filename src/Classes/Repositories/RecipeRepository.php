<?php

namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;
use App\Classes\Entities\Recipe;

class RecipeRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'recipe'; // ou 'recipes' selon ta DB
    }

    public function insertRecipe(Recipe $recipe): int
    {
        $data = [
            'title'        => $recipe->getTitle(),
            'description'  => $recipe->getDescription(),
            'duration'     => $recipe->getDuration(),
            'file_path_img'=> $recipe->getImagePath(),
            'user_id'      => $recipe->getUserId(),
            'category_id'  => $recipe->getCategoryId(),
            'created_at'   => $recipe->getCreatedAt(),
            'updated_at'   => $recipe->getUpdatedAt(),
        ];

        return $this->insert($data);
    }

    public function updateRecipe(Recipe $recipe): bool
    {
        $data = [
            'title'        => $recipe->getTitle(),
            'description'  => $recipe->getDescription(),
            'duration'     => $recipe->getDuration(),
            'file_path_img'=> $recipe->getImagePath(),
            'user_id'      => $recipe->getUserId(),
            'category_id'  => $recipe->getCategoryId(),
            'updated_at'   => $recipe->getUpdatedAt(),
        ];

        return $this->update($recipe->getId(), $data);
    }

    public function updateCategory(Recipe $recipe): bool
    {
        return $this->update($recipe->getId(), [
            'category_id' => $recipe->getCategoryId()
        ]);
    }

    public function deleteRecipe(int $id): bool
    {
        return $this->delete($id);
    }

    public function findRecipe(int $id): ?Recipe
    {
        $data = parent::find($id);
        return $data ? $this->hydrate(Recipe::class, $data) : null;
    }

    public function findAllRecipes(): array
    {
        $rows = parent::findAll();
        return array_map(fn ($row) => $this->hydrate(Recipe::class, $row), $rows);
    }
}
<?php

namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;
use App\Classes\Entities\Ingredient;

class IngredientRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'ingredient'; // ou 'ingredients' selon ta DB
    }

    public function insertIngredient(Ingredient $ingredient): int
    {
        $data = [
            'name'      => $ingredient->getName(),
            'quantity'  => $ingredient->getQuantity(),
            'unit'      => $ingredient->getUnit(),
            'recipe_id' => $ingredient->getRecipeId(),
        ];

        return $this->insert($data);
    }

    public function updateIngredient(Ingredient $ingredient): bool
    {
        $data = [
            'name'      => $ingredient->getName(),
            'quantity'  => $ingredient->getQuantity(),
            'unit'      => $ingredient->getUnit(),
            'recipe_id' => $ingredient->getRecipeId(),
        ];

        return $this->update($ingredient->getId(), $data);
    }

    public function deleteIngredient(int $id): bool
    {
        return $this->delete($id);
    }

    public function findIngredient(int $id): ?Ingredient
    {
        $data = parent::find($id);
        return $data ? $this->hydrate(Ingredient::class, $data) : null;
    }

    public function findAllIngredients(): array
    {
        $rows = parent::findAll();
        return array_map(fn ($row) => $this->hydrate(Ingredient::class, $row), $rows);
    }

    public function findByRecipe(int $recipeId): array
    {
        $rows = $this->findBy(['recipe_id' => $recipeId]);
        return array_map(fn ($row) => $this->hydrate(Ingredient::class, $row), $rows);
    }
}
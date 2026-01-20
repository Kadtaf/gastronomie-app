<?php
namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;
use App\Classes\Entities\Ingredient;

class IngredientRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'ingredient';
    }

    public function insertIngredient(Ingredient $ingredient): int
    {
        $data = [
            'name'     => $ingredient->getName(),
            'quantity' => $ingredient->getQuantity(),
            'unity'    => $ingredient->getUnity(),
        ];

        return $this->insert($data);
    }

    public function attachToRecipe(int $ingredientId, int $recipeId): void
    {
        $sql = "INSERT INTO ingredient_recipe (ingredient_id, recipe_id)
                VALUES (:ingredient_id, :recipe_id)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'ingredient_id' => $ingredientId,
            'recipe_id'     => $recipeId,
        ]);
    }

    public function findByRecipe(int $recipeId): array
    {
        $sql = "
            SELECT i.*
            FROM ingredient i
            JOIN ingredient_recipe ir ON ir.ingredient_id = i.id
            WHERE ir.recipe_id = :recipe_id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['recipe_id' => $recipeId]);

        $rows = $stmt->fetchAll();

        return array_map(fn($row) => $this->hydrate(Ingredient::class, $row), $rows);
    }

    public function detachFromRecipe(int $recipeId): bool
    {
        $sql = "DELETE FROM ingredient_recipe WHERE recipe_id = :recipe_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':recipe_id' => $recipeId]);
    }
}
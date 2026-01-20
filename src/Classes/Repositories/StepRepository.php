<?php

namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;
use App\Classes\Entities\Step;

class StepRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'step'; 
    }

    public function insertStep(Step $step): int
    {
    $data = [
        'recipe_id'   => $step->getRecipeId(),
        'order_step' => $step->getOrderStep(),
        'description' => $step->getDescription(),
        
    ];

    return $this->insert($data);
    }

    public function updateStep(Step $step): bool
    {
    $data = [
        'recipe_id'   => $step->getRecipeId(),
        'order_step' => $step->getOrderStep(),
        'description' => $step->getDescription(),
        
    ];

    return $this->update($step->getId(), $data);
    }

    public function deleteStep(int $id): bool
    {
        return $this->delete($id);
    }

    public function findStep(int $id): ?Step
    {
        $data = parent::find($id);
        return $data ? $this->hydrate(Step::class, $data) : null;
    }

    public function findAllSteps(): array
    {
        $rows = parent::findAll();
        return array_map(fn ($row) => $this->hydrate(Step::class, $row), $rows);
    }

    public function findByRecipe(int $recipeId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE recipe_id = :recipe_id ORDER BY order_step ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':recipe_id' => $recipeId]);
        
        $steps = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return array_map(fn($row) => $this->hydrate(Step::class, $row), $steps);
    }

    public function deleteByRecipe(int $recipeId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE recipe_id = :recipe_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':recipe_id' => $recipeId]);
    }
}
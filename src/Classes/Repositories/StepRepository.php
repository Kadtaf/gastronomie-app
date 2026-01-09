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
            "order"     => $step->getOrder(),
            "description" => $step->getDescription(),
            "recipe_id" => $step->getRecipeId(),
        ];

        return $this->insert($data);
    }

    public function updateStep(Step $step): bool
    {
        $data = [
            "order"       => $step->getOrder(),
            "description" => $step->getDescription(),
            "recipe_id"   => $step->getRecipeId(),
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
        return array_map(fn($row) => $this->hydrate(Step::class, $row), $rows);
    }

    public function findByRecipe(int $recipeId): array
    {
        $rows = $this->findBy(["recipe_id" => $recipeId]);
        return array_map(fn($row) => $this->hydrate(Step::class, $row), $rows);
    }
}
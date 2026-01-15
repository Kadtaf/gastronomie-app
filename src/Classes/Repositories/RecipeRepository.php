<?php

namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;
use App\Classes\Entities\Recipe;

class RecipeRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'recipe'; 
    }

    public function insertRecipe(Recipe $recipe): int
    {
        $data = [
            'title'        => $recipe->getTitle(),
            'description'  => $recipe->getDescription(),
            'duration'     => $recipe->getDuration(),
            'file_path_img'=> $recipe->getFilePathImg(),
            'user_id'      => $recipe->getUserId(),
            'category_id'  => $recipe->getCategoryId(),
            'created_at'   => $recipe->getCreatedAt(),
            'updated_at'   => $recipe->getUpdatedAt(),
            'difficulty' => $recipe->getDifficulty(),
        ];

        return $this->insert($data);
    }

    public function updateRecipe(Recipe $recipe): bool
    {
        $data = [
            'title'        => $recipe->getTitle(),
            'description'  => $recipe->getDescription(),
            'duration'     => $recipe->getDuration(),
            'file_path_img'=> $recipe->getFilePathImg(),
            'user_id'      => $recipe->getUserId(),
            'category_id'  => $recipe->getCategoryId(),
            'updated_at'   => $recipe->getUpdatedAt(),
            'difficulty' => $recipe->getDifficulty(),
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

    public function findWithFilters(array $filters, int $limit, int $offset): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];

        // Filtre catégorie
        if (!empty($filters['category_id'])) {
            $sql .= " AND category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        // Filtre difficulté
        if (!empty($filters['difficulty'])) {
            $sql .= " AND difficulty = :difficulty";
            $params['difficulty'] = $filters['difficulty'];
        } else {
            $sql .= " AND difficulty IS NOT NULL";
        }

        // Filtre durée
        if (!empty($filters['duration'])) {
            $sql .= " AND duration <= :duration";
            $params['duration'] = (int)$filters['duration'];
        }

        // Pagination
        $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        // Bind des paramètres dynamiques
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // Bind pagination
        $stmt->bindValue(":limit", $limit, \PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, \PDO::PARAM_INT);

        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(fn ($row) => $this->hydrate(Recipe::class, $row), $rows);
    }

    public function countWithFilters(array $filters): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!empty($filters['category_id'])) {
            $sql .= " AND category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['difficulty'])) {
            $sql .= " AND difficulty = :difficulty";
            $params['difficulty'] = $filters['difficulty'];
        }

        if (!empty($filters['duration'])) {
            $sql .= " AND duration <= :duration";
            $params['duration'] = $filters['duration'];
        }   

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}
<?php

namespace App\Classes\Core;

use PDO;

abstract class AbstractRepository
{
    protected string $table;
    protected PDO $db;

    public function __construct()
    {
        $this->db = Dbase::getInstance();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ?: null;
    }

    public function findBy(array $criteria): array
    {
        $columns = [];
        $params = [];

        foreach ($criteria as $column => $value) {
            $columns[] = "$column = :$column";
            $params[":$column"] = $value;
        }

        $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $columns);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn ($c) => ":$c", $columns);

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ")
                VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $columns = [];
        $params = [];

        foreach ($data as $column => $value) {
            $columns[] = "$column = :$column";
            $params[":$column"] = $value;
        }

        $params[':id'] = $id;

        $sql = "UPDATE {$this->table} 
                SET " . implode(', ', $columns) . " 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    public function hydrate(string $class, array $data)
    {
        $object = new $class();

        foreach ($data as $key => $value) {
            // Convertit snake_case → camelCase
            // recipe_id → recipeId → setRecipeId
            $camelCase = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            $setter = 'set' . ucfirst($camelCase);

            if (method_exists($object, $setter)) {
                $object->$setter($value);
            }
        }

        return $object;
    }

    public function paginate(int $page= 1, int $perPage =10): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table}");
        $stmt->execute();
        $total = (int) $stmt->fetchColumn();

        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data'       => $stmt->fetchAll(\PDO::FETCH_ASSOC),
            'total'      => $total,
            'perPage'    => $perPage,
            'current'    => $page,
            'lastPage'   => (int) ceil($total / $perPage),
        ];

    }
}
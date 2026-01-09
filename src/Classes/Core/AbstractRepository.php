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
        $stmt->execute([":id" => $id]);

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

        $sql = "SELECT * FROM {$this->table} WHERE " . implode(" AND ", $columns);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($c) => ":$c", $columns);

        $sql = "INSERT INTO {$this->table} (" . implode(", ", $columns) . ")
                VALUES (" . implode(", ", $placeholders) . ")";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $columns = [];
        foreach ($data as $column => $value) {
            $columns[] = "$column = :$column";
        }

        $data[":id"] = $id;

        $sql = "UPDATE {$this->table} SET " . implode(", ", $columns) . " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    public function hydrate(string $class, array $data)
    {
        $object = new $class();

        foreach ($data as $key => $value) {
            $setter = "set" . str_replace(" ", "", ucwords(str_replace("_", " ", $key)));

            if (method_exists($object, $setter)) {
                $object->$setter($value);
            }
        }

        return $object;
    }
}
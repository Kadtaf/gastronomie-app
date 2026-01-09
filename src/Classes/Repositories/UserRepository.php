<?php
namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;
use App\Classes\Entities\User;

class UserRepository extends AbstractRepository 
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'user';
    }

    public function insertUser(User $user): int
    {
        $data = [
            "lastname"   => $user->getLastname(),
            "firstname"  => $user->getFirstname(),
            "email"      => $user->getEmail(),
            "password"   => $user->getPassword(),
            "role"       => $user->getRole(),
            "created_at" => $user->getCreatedAt(),
            "updated_at" => $user->getUpdatedAt(),
        ];

        return $this->insert($data);
    }

    public function updateUser(User $user): bool
    {
        $data = [
            "lastname"   => $user->getLastname(),
            "firstname"  => $user->getFirstname(),
            "email"      => $user->getEmail(),
            "password"   => $user->getPassword(),
            "role"       => $user->getRole(),
            "updated_at" => $user->getUpdatedAt(),
        ];

        return $this->update($user->getId(), $data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }

    public function findUser(int $id): ?User
    {
        $data = parent::find($id);
        return $data ? $this->hydrate(User::class, $data) : null;
    }

    public function findAllUsers(): array
    {
        $rows = parent::findAll();
        return array_map(fn($row) => $this->hydrate(User::class, $row), $rows);
    }

    public function findByEmail(string $email): ?User
    {
        $rows = $this->findBy(["email" => $email]);
        if (empty($rows)) {
            return null;
        }
        return $this->hydrate(User::class, $rows[0]);
    }

    public function verifyCredentials(string $email, string $password): ?User
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user->getPassword())) {
            return null;
        }

        return $user;
    }
}
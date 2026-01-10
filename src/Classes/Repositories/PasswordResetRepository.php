<?php

namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;

class PasswordResetRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'password_resets';
    }

    public function createToken(string $email, string $token): void
    {
        $this->deleteByEmail($email);

        $sql = "INSERT INTO password_resets (email, token, created_at)
                VALUES (:email, :token, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $email,
            'token' => $token
        ]);
    }

    public function findByToken(string $token): ?array
    {
        $sql = "SELECT * FROM password_resets WHERE token = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);

        return $stmt->fetch() ?: null;
    }

    public function deleteByEmail(string $email): void
    {
        $sql = "DELETE FROM password_resets WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
    }

    public function deleteToken(string $token): void
    {
        $sql = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
    }
}
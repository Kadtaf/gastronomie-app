<?php
namespace App\Classes\Entities;



class User 
{
    private ?int $id = null;

    protected string $lastname;
    protected string $firstname;
    protected string $email;
    protected string $password;
    protected string $role;

    protected string $created_at;
    protected string $updated_at;

    public function __construct(
        string $lastname,
        string $firstname,
        string $email,
        string $password,
        string $role,
        string $created_at,
        string $updated_at
    ) {
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
        $this->role = $role;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}
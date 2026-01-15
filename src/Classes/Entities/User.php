<?php

namespace App\Classes\Entities;

class User
{
    private ?int $id = null;

    private string $lastName;
    private string $firstName;
    private string $email;
    private string $password;
    private string $role;

    private string $createdAt;
    private string $updatedAt;



    public function __construct(
        ?string $lastName = null,
        ?string $firstName = null,
        ?string $email = null,
        ?string $password = null,
        ?string $role = 'user',
        ?string $createdAt = null,
        ?string $updatedAt = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->lastName = $lastName ?? '';
        $this->firstName = $firstName ?? '';
        $this->email = $email ?? '';
        $this->password = $password ?? '';
        $this->role = $role ?? 'user';
        $this->createdAt = $createdAt ?? '';
        $this->updatedAt = $updatedAt ?? '';
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getlastName(): string
    {
        return $this->lastName;
    }

    public function setlastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getfirstName(): string
    {
        return $this->firstName;
    }

    public function setfirstName(string $firstName): self
    {
        $this->firstName = $firstName;
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
        $this->password = $password; // NE PAS HASHER ICI
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
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
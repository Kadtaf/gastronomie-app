<?php

namespace App\Classes\Entities;

class Step
{
    private ?int $id = null;

    private int $order;
    private string $description;
    private int $recipeId;

    public function __construct(
        int $order,
        string $description,
        int $recipeId
    ) {
        $this->order = $order;
        $this->description = $description;
        $this->recipeId = $recipeId;
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

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getRecipeId(): int
    {
        return $this->recipeId;
    }

    public function setRecipeId(int $recipeId): self
    {
        $this->recipeId = $recipeId;
        return $this;
    }
}
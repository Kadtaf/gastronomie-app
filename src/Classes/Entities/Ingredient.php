<?php

namespace App\Classes\Entities;

class Ingredient
{
    private ?int $id = null;

    private string $name;
    private float $quantity;
    private string $unit;
    private int $recipeId;

    public function __construct(
        string $name,
        float $quantity,
        string $unit,
        int $recipeId
    ) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unit = $unit;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;
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
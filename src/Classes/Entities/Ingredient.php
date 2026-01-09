<?php
namespace App\Classes\Entities;



class Ingredient 
{
    private ?int $id = null;

    protected string $name;
    protected float $quantity;
    protected string $unit;
    protected int $recipe_id;

    public function __construct(
        string $name,
        float $quantity,
        string $unit,
        int $recipe_id
    ) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unit = $unit;
        $this->recipe_id = $recipe_id;
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->recipe_id;
    }

    public function setRecipeId(int $recipe_id): self
    {
        $this->recipe_id = $recipe_id;
        return $this;
    }
}
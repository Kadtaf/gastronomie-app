<?php
namespace App\Classes\Entities;



class Step 
{
    private ?int $id = null;

    protected int $order;
    protected string $description;
    protected int $recipe_id;

    public function __construct(
        int $order,
        string $description,
        int $recipe_id
    ) {
        $this->order = $order;
        $this->description = $description;
        $this->recipe_id = $recipe_id;
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->recipe_id;
    }

    public function setRecipeId(int $recipe_id): self
    {
        $this->recipe_id = $recipe_id;
        return $this;
    }
}
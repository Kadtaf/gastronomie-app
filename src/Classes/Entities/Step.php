<?php

namespace App\Classes\Entities;

class Step
{
    private ?int $id = null;

    private ?int $orderStep = null;
    private ?string $description = null;
    private ?int $recipeId = null;

    public function __construct()
    {
        // Constructeur vide - utiliser les setters
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

    public function getOrderStep(): ?int
    {
        return $this->orderStep;
    }

    public function setOrderStep(int $orderStep): self
    {
        $this->orderStep = $orderStep;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getRecipeId(): ?int
    {
        return $this->recipeId;
    }

    public function setRecipeId(int $recipeId): self
    {
        $this->recipeId = $recipeId;
        return $this;
    }
}
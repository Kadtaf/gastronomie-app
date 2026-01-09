<?php
namespace App\Classes\Entities;



class Comment 
{
    private ?int $id = null;

    protected string $content;
    protected string $created_at;
    protected string $updated_at;

    protected int $user_id;
    protected int $recipe_id;

    public function __construct(
        string $content,
        int $user_id,
        int $recipe_id,
        string $created_at,
        string $updated_at
    ) {
        $this->content = $content;
        $this->user_id = $user_id;
        $this->recipe_id = $recipe_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
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

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
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
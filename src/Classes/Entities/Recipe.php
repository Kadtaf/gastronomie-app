<?php
namespace App\Classes\Entities;



class Recipe 
{
    private ?int $id = null;

    protected string $title;
    protected string $description;
    protected int $duration; // en minutes
    protected ?string $file_path_img;

    protected int $user_id;
    protected ?int $category_id = null;

    protected string $created_at;
    protected string $updated_at;

    public function __construct(
        string $title,
        string $description,
        int $duration,
        ?string $file_path_img,
        int $user_id,
        string $created_at,
        string $updated_at
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->duration = $duration;
        $this->file_path_img = $file_path_img;
        $this->user_id = $user_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
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

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getFilePathImg(): ?string
    {
        return $this->file_path_img;
    }

    public function setFilePathImg(?string $file_path_img): self
    {
        $this->file_path_img = $file_path_img;
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

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(?int $category_id): self
    {
        $this->category_id = $category_id;
        return $this;
    }
}
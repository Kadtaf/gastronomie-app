<?php

namespace App\Classes\Entities;

class Recipe
{
    private ?int $id = null;

    private ?string $title = null;
    private ?string $description = null;
    private ?int $duration = null;
    private ?string $filePathImg = null;
    private ?int $userId = null;
    private ?int $categoryId = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;
    private ?string $difficulty = null;


    

    public function __construct() {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
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

    public function getDuration(): ?int
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
        return $this->filePathImg;
    }

    public function setFilePathImg(string $path): self
    {
        $this->filePathImg = $path;
        return $this;
    }


    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): self
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;
        return $this;
    }

    public function getDurationFormatted(): string
    {
        $minutes = $this->duration;

        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return $hours . 'h ' . ($mins > 0 ? $mins . ' min' : '');
        }

        return $mins . ' min';
    }

}
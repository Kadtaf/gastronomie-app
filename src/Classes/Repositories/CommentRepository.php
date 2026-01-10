<?php

namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;
use App\Classes\Entities\Comment;

class CommentRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'comment'; // ou 'comments' selon ta DB
    }

    public function insertComment(Comment $comment): int
    {
        $data = [
            'content'    => $comment->getContent(),
            'user_id'    => $comment->getUserId(),
            'recipe_id'  => $comment->getRecipeId(),
            'created_at' => $comment->getCreatedAt(),
            'updated_at' => $comment->getUpdatedAt(),
        ];

        return $this->insert($data);
    }

    public function updateComment(Comment $comment): bool
    {
        $data = [
            'content'    => $comment->getContent(),
            'user_id'    => $comment->getUserId(),
            'recipe_id'  => $comment->getRecipeId(),
            'updated_at' => $comment->getUpdatedAt(),
        ];

        return $this->update($comment->getId(), $data);
    }

    public function deleteComment(int $id): bool
    {
        return $this->delete($id);
    }

    public function findComment(int $id): ?Comment
    {
        $data = parent::find($id);
        return $data ? $this->hydrate(Comment::class, $data) : null;
    }

    public function findAllComments(): array
    {
        $rows = parent::findAll();
        return array_map(fn ($row) => $this->hydrate(Comment::class, $row), $rows);
    }

    public function findByRecipe(int $recipeId): array
    {
        $rows = $this->findBy(['recipe_id' => $recipeId]);
        return array_map(fn ($row) => $this->hydrate(Comment::class, $row), $rows);
    }

    public function findByUser(int $userId): array
    {
        $rows = $this->findBy(['user_id' => $userId]);
        return array_map(fn ($row) => $this->hydrate(Comment::class, $row), $rows);
    }
}
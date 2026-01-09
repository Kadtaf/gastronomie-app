<?php
namespace App\Classes\Controllers;

use App\Classes\Controllers\AbstractController;
use App\Classes\Repositories\CommentRepository;
use App\Classes\Entities\Comment;
use DateTimeImmutable;

class CommentController extends AbstractController
{
    public function add(int $recipeId)
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $this->renderView("Comments/add", [
                "recipeId" => $recipeId
            ]);
        }

        $errors = [];

        if (empty($_POST["content"])) {
            $errors["content"] = "Le commentaire ne peut pas être vide.";
        }

        if (!empty($errors)) {
            return $this->renderView("Comments/add", [
                "errors" => $errors,
                "recipeId" => $recipeId
            ]);
        }

        $date = new DateTimeImmutable();

        $comment = new Comment(
            strip_tags($_POST["content"]),
            1, // user_id
            $recipeId,
            $date->format("Y-m-d H:i:s"),
            $date->format("Y-m-d H:i:s")
        );

        $commentRepository = new CommentRepository();
        $commentRepository->insertComment($comment);

        return $this->redirect("/recipe/show/$recipeId");
    }

    public function delete(int $id)
    {
        $commentRepository = new CommentRepository();
        $commentRepository->deleteComment($id);

        return $this->redirect("/recipe/index");
    }
}
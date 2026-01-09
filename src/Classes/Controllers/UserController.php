<?php
namespace App\Classes\Controllers;

use App\Classes\Controllers\AbstractController;
use App\Classes\Repositories\UserRepository;
use App\Classes\Entities\User;
use DateTimeImmutable;

class UserController extends AbstractController
{
    public function index()
    {
        $userRepository = new UserRepository();
        $users = $userRepository->findAllUsers();

        return $this->renderView("Users/index", [
            "users" => $users
        ]);
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            return $this->renderView("Users/add");
        }

        // Validation
        $errors = [];

        $required = ["lastname", "firstname", "email", "password", "role"];

        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = "Le champ $field est obligatoire.";
            }
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "L'adresse email est invalide.";
        }

        $userRepository = new UserRepository();
        if ($userRepository->findByEmail($_POST["email"])) {
            $errors["email"] = "Cet email est déjà utilisé.";
        }

        if (!empty($errors)) {
            return $this->renderView("Users/add", [
                "errors" => $errors
            ]);
        }

        // Création de l'utilisateur
        $date = new DateTimeImmutable();

        $user = new User(
            strip_tags($_POST["lastname"]),
            strip_tags($_POST["firstname"]),
            strip_tags($_POST["email"]),
            password_hash($_POST["password"], PASSWORD_DEFAULT),
            strip_tags($_POST["role"]),
            $date->format("Y-m-d H:i:s"),
            $date->format("Y-m-d H:i:s")
        );

        $userRepository->insertUser($user);

        return $this->redirect("/user/index");
    }
}
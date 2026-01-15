<?php

namespace App\Classes\Controllers;

use App\Classes\Repositories\UserRepository;
use App\Classes\Entities\User;
use DateTimeImmutable;
use App\Classes\Core\Flash;

class UserController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function index(): void
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $pagination = $this->userRepository->paginate($page, 10);

        $this->renderView('Users/index', [
            'users'      => $pagination['data'],
            'pagination' => $pagination
        ], layout: 'main');
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->renderView('Users/add', [], layout: 'main');
            return;
        }

        // Validation
        $errors = $this->validateUserForm($_POST);

        if (!empty($errors)) {
            Flash::add('error', 'Veuillez corriger les erreurs du formulaire.');

            $this->renderView('Users/add', [
                'errors' => $errors,
                'old' => $_POST
            ], layout: 'main');
            return;
        }

        // Create user
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $user = new User(
            strip_tags($_POST['lastname']),
            strip_tags($_POST['firstname']),
            strip_tags($_POST['email']),
            password_hash($_POST['password'], PASSWORD_DEFAULT),
            strip_tags($_POST['role']),
            $now,
            $now
        );

        $this->userRepository->insertUser($user);
        Flash::add('success', 'Utilisateur créé avec succès.');

        $this->redirect('/user/index');
    }

    private function validateUserForm(array $data): array
    {
        $errors = [];
        $required = ['lastname', 'firstname', 'email', 'password', 'role'];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "Le champ $field est obligatoire.";
            }
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'adresse email est invalide.";
        }

        if (!empty($data['email']) && $this->userRepository->findByEmail($data['email'])) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }

        return $errors;
    }
}
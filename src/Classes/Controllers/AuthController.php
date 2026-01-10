<?php

namespace App\Classes\Controllers;

use App\Classes\Repositories\UserRepository;
use App\Classes\Entities\User;
use DateTimeImmutable;

class AuthController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        session_start();
        $this->userRepository = new UserRepository();
        $this->autoLogin();
    }

    private function autoLogin(): void
    {
        // Si déjà connecté → rien à faire
        if (isset($_SESSION['user'])) {
            return;
        }

        // Si aucun cookie → rien à faire
        if (empty($_COOKIE['remember_me'])) {
            return;
        }

        // Format : "userId:token"
        [$userId, $token] = explode(':', $_COOKIE['remember_me']);

        $user = $this->userRepository->findByRememberToken((int)$userId, $token);

        if ($user) {
            $_SESSION['user'] = [
                'id'        => $user->getId(),
                'firstname' => $user->getFirstName(),
                'lastname'  => $user->getLastName(),
                'email'     => $user->getEmail(),
                'role'      => $user->getRole(),
            ];
        }
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view('Auth/login', [
                'title' => 'Connexion'
            ]);
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $key = 'login_' . $email;

        // 1. Trop de tentatives ?
        if (\App\Classes\Core\RateLimiter::tooManyAttempts($key)) {
            $seconds = \App\Classes\Core\RateLimiter::availableIn($key);

            $this->flash('error', "Trop de tentatives. Réessayez dans $seconds secondes.");
            $this->redirect('/login');
        }

        // 2. Vérifier identifiants
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {

            \App\Classes\Core\RateLimiter::hit($key);

            $this->flash('error', "Identifiants incorrects.");
            $this->redirect('/login');
        }

        // 3. Login OK → reset compteur
        \App\Classes\Core\RateLimiter::clear($key);

        // 4. Stocker l'utilisateur en session
        $_SESSION['user'] = [
            'id'        => $user->getId(),
            'firstname' => $user->getFirstName(),
            'lastname'  => $user->getLastName(),
            'email'     => $user->getEmail(),
            'role'      => $user->getRole(),
        ];

        // 5. Remember Me
        if (!empty($_POST['remember'])) {
            $token = bin2hex(random_bytes(32));
            $this->userRepository->updateRememberToken($user->getId(), $token);

            setcookie(
                'remember_me',
                $user->getId() . ':' . $token,
                time() + (86400 * 30),
                '/',
                '',
                true,
                true
            );
        }

        // 6. Message de succès
        $this->flash('success', 'Connexion réussie !');

        // 7. Redirection
        $this->redirect('/admin/dashboard');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view('Auth/register', [
                'title' => 'Inscription'
            ]);
            return;
        }

        // Validation
        $errors = $this->validate($_POST, [
            'firstname'             => 'required|string|max:50',
            'lastname'              => 'required|string|max:50',
            'email'                 => 'required|email',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|confirmed',
        ]);

        // Email déjà utilisé ?
        if (empty($errors['email']) && $this->userRepository->findByEmail($_POST['email'])) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }

        if (!empty($errors)) {
            $this->flash('error', "Veuillez corriger les erreurs du formulaire.");
            $this->view('Auth/register', [
                'errors' => $errors,
                'old'    => $_POST,
            ]);
            return;
        }

        // Création utilisateur
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $user = new User(
            strip_tags($_POST['lastname']),
            strip_tags($_POST['firstname']),
            strip_tags($_POST['email']),
            password_hash($_POST['password'], PASSWORD_DEFAULT),
            'user',
            $now,
            $now
        );

        $this->userRepository->insertUser($user);

        // Auto login
        $user = $this->userRepository->findByEmail($_POST['email']);

        $_SESSION['user'] = [
            'id'        => $user->getId(),
            'firstname' => $user->getFirstName(),
            'lastname'  => $user->getLastName(),
            'email'     => $user->getEmail(),
            'role'      => $user->getRole(),
        ];

        $this->flash('success', 'Inscription réussie ! Bienvenue.');
        $this->redirect('/admin/dashboard');
    }

    public function logout(): void
    {
        session_start();
        session_destroy();

        // Supprimer le cookie remember_me
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);

        $this->flash('success', 'Vous êtes maintenant déconnecté.');
        $this->redirect('/login');
    }

    public function forgotPassword(): void
    {
        // afficher le formulaire et gérer l'envoi de l'email avec un token
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $this->renderView('Auth/forgot_password', [], layout: 'main');
        return;
    }

    $email = trim($_POST['email'] ?? '');

    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Adresse email invalide.";
    }

    $user = $this->userRepository->findByEmail($email);

    if (!$user) {
        $errors['email'] = "Aucun compte trouvé avec cet email.";
    }

    if (!empty($errors)) {
        $this->renderView('Auth/forgot_password', [
            'errors' => $errors,
            'old' => $_POST
        ], layout: 'main');
        return;
    }

    // Générer un token
    $token = bin2hex(random_bytes(32));

    // Stocker en base
    $resetRepo = new \App\Classes\Repositories\PasswordResetRepository();
    $resetRepo->createToken($email, $token);

    // Ici on enverrais un email plus tard
    // Pour l'instant on affiche le lien (dev mode)
    echo "<p>Lien de réinitialisation :</p>";
    echo "<a href='/reset-password/$token'>Réinitialiser le mot de passe</a>";
    }

    public function resetPassword(string $token): void
    {
        // afficher le formulaire et gérer la réinitialisation du mot de passe
        $resetRepo = new \App\Classes\Repositories\PasswordResetRepository();
        $reset = $resetRepo->findByToken($token);

    if (!$reset) {
        echo "Lien invalide ou expiré.";
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $this->renderView('Auth/reset_password', [
            'token' => $token
        ], layout: 'main');
        return;
    }

    // Validation
    $errors = $this->validate($_POST, [
        'password' => 'required|min:6',
        'password_confirmation' => 'required|confirmed'
    ]);

    if (!empty($errors)) {
        $this->renderView('Auth/reset_password', [
            'errors' => $errors,
            'token' => $token
        ], layout: 'main');
        return;
    }

    // Mettre à jour le mot de passe
    $user = $this->userRepository->findByEmail($reset['email']);
    $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
    $user->setUpdatedAt(date('Y-m-d H:i:s'));

    $this->userRepository->updateUser($user);

    // Supprimer le token
    $resetRepo->deleteToken($token);

    $this->flash('success', 'Mot de passe mis à jour. Vous pouvez maintenant vous connecter.');
    $this->redirect('/login');

    }
}
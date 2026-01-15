<?php $this->startSection('title'); ?>
Inscription
<?php $this->endSection(); ?>

<?php if (!empty($errors['login'])): ?>
    <?php $this->component('alert', [
        'type' => 'error',
        'message' => $errors['login']
    ]); ?>
<?php endif; ?>

<h1>Inscription</h1>

<form action="/register" method="POST">

    <?= $this->csrfField() ?>

    <?php $this->component('input', [
        'label' => 'Prénom',
        'name'  => 'firstname',
        'value' => $this->old('firstname'),
        'error' => $errors['firstname'] ?? null
    ]); ?>

    <?php $this->component('input', [
        'label' => 'Nom',
        'name'  => 'lastname',
        'value' => $this->old('lastname'),
        'error' => $errors['lastname'] ?? null
    ]); ?>

    <?php $this->component('input', [
        'label' => 'Email',
        'name'  => 'email',
        'type'  => 'email',
        'value' => $this->old('email'),
        'error' => $errors['email'] ?? null
    ]); ?>

    <?php $this->component('input', [
        'label' => 'Mot de passe',
        'name'  => 'password',
        'type'  => 'password',
        'error' => $errors['password'] ?? null
    ]); ?>

    <?php $this->component('input', [
        'label' => 'Confirmer le mot de passe',
        'name'  => 'password_confirmation',
        'type'  => 'password',
        'error' => $errors['password_confirmation'] ?? null
    ]); ?>

    <?php $this->component('button', [
        'variant' => 'primary',
        'label'   => 'Créer un compte'
    ]); ?>

</form>

<p>Déjà un compte ? <a href="/login">Se connecter</a></p>
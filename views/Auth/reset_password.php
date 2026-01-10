<h1>Nouveau mot de passe</h1>

<form action="/reset-password/<?= $token ?>" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->csrfToken()) ?>">

    <label>Nouveau mot de passe :</label>
    <input type="password" name="password">

    <label>Confirmer le mot de passe :</label>
    <input type="password" name="password_confirmation">

    <?php if (!empty($errors['password'])): ?>
        <p class="error"><?= $errors['password'] ?></p>
    <?php endif; ?>

    <button type="submit">Réinitialiser</button>
</form>
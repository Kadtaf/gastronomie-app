<h1>Mot de passe oublié</h1>

<form action="/forgot-password" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->csrfToken()) ?>">

    <label>Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">

    <?php if (!empty($errors['email'])): ?>
        <p class="error"><?= $errors['email'] ?></p>
    <?php endif; ?>

    <button type="submit">Envoyer le lien</button>
</form>
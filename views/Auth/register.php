<h1>Inscription</h1>

<form action="/register" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->csrfToken()) ?>">

    <label>Prénom :</label>
    <input type="text" name="firstname" value="<?= htmlspecialchars($old['firstname'] ?? '') ?>">
    <?php if (!empty($errors['firstname'])): ?>
        <p class="error"><?= $errors['firstname'] ?></p>
    <?php endif; ?>

    <label>Nom :</label>
    <input type="text" name="lastname" value="<?= htmlspecialchars($old['lastname'] ?? '') ?>">
    <?php if (!empty($errors['lastname'])): ?>
        <p class="error"><?= $errors['lastname'] ?></p>
    <?php endif; ?>

    <label>Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
    <?php if (!empty($errors['email'])): ?>
        <p class="error"><?= $errors['email'] ?></p>
    <?php endif; ?>

    <label>Mot de passe :</label>
    <input type="password" name="password">
    <?php if (!empty($errors['password'])): ?>
        <p class="error"><?= $errors['password'] ?></p>
    <?php endif; ?>

    <label>Confirmer le mot de passe :</label>
    <input type="password" name="password_confirmation">
    <?php if (!empty($errors['password_confirmation'])): ?>
        <p class="error"><?= $errors['password_confirmation'] ?></p>
    <?php endif; ?>

    <button type="submit">Créer un compte</button>
</form>

<p>Déjà un compte ? <a href="/login">Se connecter</a></p>
<h1>Connexion</h1>

<form action="/login" method="POST">
    
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($this->csrfToken()) ?>">


    <label>Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">

    <label>Mot de passe :</label>
    <input type="password" name="password">

    <?php if (!empty($errors['login'])): ?>
        <p class="error"><?= $errors['login'] ?></p>
    <?php endif; ?>

    <button type="submit">Se connecter</button>

    <label>
        <input type="checkbox" name="remember">
        Se souvenir de moi
    </label>
</form>
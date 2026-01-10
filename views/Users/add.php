<h1>Ajouter un utilisateur</h1>

<form action="/user/add" method="POST">

    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->csrfToken()) ?>">

    <label>Nom :</label>
    <input type="text" name="lastname" value="<?= htmlspecialchars($old['lastname'] ?? '') ?>">
    <?php if (!empty($errors['lastname'])): ?>
        <p class="error"><?= $errors['lastname'] ?></p>
    <?php endif; ?>

    <label>Prénom :</label>
    <input type="text" name="firstname" value="<?= htmlspecialchars($old['firstname'] ?? '') ?>">
    <?php if (!empty($errors['firstname'])): ?>
        <p class="error"><?= $errors['firstname'] ?></p>
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

    <label>Rôle :</label>
    <select name="role">
        <option value="user">Utilisateur</option>
        <option value="admin">Administrateur</option>
    </select>

    <button type="submit">Créer</button>
</form>
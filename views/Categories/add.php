<h1>Ajouter une catégorie</h1>

<form action="/category/add" method="POST">

    <label for="name">Nom de la catégorie :</label>
    <input type="text" name="name" id="name"
            value="<?= htmlspecialchars($old['name'] ?? '') ?>">

    <?php if (!empty($errors['name'])): ?>
        <p style="color:red;"><?= $errors['name'] ?></p>
    <?php endif; ?>

    <button type="submit">Créer</button>
</form> 
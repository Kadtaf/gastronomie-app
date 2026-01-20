<h1>Modifier la recette</h1>

<form action="/recipe/edit/<?= $recipe->getId() ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($this->csrfToken()) ?>">
    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($recipe->getTitle()) ?>">
    <?php if (!empty($errors['title'])): ?>
        <p class="field-error"><?= $errors['title'] ?></p>
    <?php endif; ?>


    <label for="description">Description :</label>
    <textarea name="description" id="description"><?= htmlspecialchars($recipe->getDescription()) ?></textarea>
    <?php if (!empty($errors['description'])): ?>
        <p class="field-error"><?= $errors['description'] ?></p>
    <?php endif; ?>


    <label for="duration">Durée (minutes) :</label>
    <input type="number" name="duration" id="duration" value="<?= htmlspecialchars($recipe->getDuration()) ?>">
    <?php if (!empty($errors['duration'])): ?>
        <p class="field-error"><?= $errors['duration'] ?></p>
    <?php endif; ?>


    <label for="categories">Catégorie :</label>
    <select name="categories" id="categories">
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat->getId() ?>"
                <?= $cat->getId() == $recipe->getCategoryId() ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat->getName()) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <h2>Ingrédients</h2>

    <div id="ingredients">
        <?php foreach ($ingredients as $ingredient): ?>
            <div class="ingredient">
                <input type="text" name="name_ingredient[]" value="<?= htmlspecialchars($ingredient->getName()) ?>" placeholder="Nom">
                <input type="number" name="quantity_ingredient[]" value="<?= htmlspecialchars($ingredient->getQuantity()) ?>" placeholder="Quantité">
                <input type="text" name="unity_ingredient[]" value="<?= htmlspecialchars($ingredient->getUnity()) ?>" placeholder="Unité">
                <button type="button" class="remove-btn" onclick="removeField(this)">Supprimer</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addIngredient()">Ajouter un ingrédient</button>

    <h2>Étapes</h2>
    <div id="steps">
        <?php foreach ($steps as $step): ?>
            <div class="step">
                <input type="number" name="order_step[]" value="<?= htmlspecialchars($step->getOrderStep()) ?>" placeholder="Ordre">
                <input type="text" name="description_step[]" value="<?= htmlspecialchars($step->getDescription()) ?>" placeholder="Description de l'étape">
                <button type="button" class="remove-btn" onclick="removeField(this)">Supprimer</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addStep()">Ajouter une étape</button>

    <label>Image actuelle :</label>
    <img src="<?= htmlspecialchars($recipe->getFilePathImg()) ?>" width="150">

    <label for="img">Nouvelle image (optionnel) :</label>
    <input type="file" name="img" id="img">

    <label for="difficulty">Difficulté</label>
    <select name="difficulty" id="difficulty">
        <option value="facile" <?= $recipe->getDifficulty() === 'facile' ? 'selected' : '' ?>>Facile</option>
        <option value="moyenne" <?= $recipe->getDifficulty() === 'moyenne' ? 'selected' : '' ?>>Moyenne</option>
        <option value="difficile" <?= $recipe->getDifficulty() === 'difficile' ? 'selected' : '' ?>>Difficile</option>
    </select>

    <button type="submit" class="btn btn-success">Mettre à jour</button>
</form>
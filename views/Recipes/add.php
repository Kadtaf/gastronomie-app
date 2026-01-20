<h1>Ajouter une recette</h1>

<form class="recipe-form" action="/recipe/add" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($this->csrfToken()) ?>">

    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>">
    <?php if (!empty($errors['title'])): ?>
        <p class="field-error"><?= $errors['title'] ?></p>
    <?php endif; ?>

    <label for="description">Description :</label>
    <textarea name="description" id="description"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    <?php if (!empty($errors['description'])): ?>
        <p class="field-error"><?= $errors['description'] ?></p>
    <?php endif; ?>

    <label for="duration">Durée (minutes) :</label>
    <input type="number" name="duration" id="duration" value="<?= htmlspecialchars($old['duration'] ?? '') ?>">
    <?php if (!empty($errors['duration'])): ?>
        <p class="field-error"><?= $errors['duration'] ?></p>
    <?php endif; ?>

    <label for="categories">Catégorie :</label>
    <select name="categories" id="categories">
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat->getId() ?>">
                <?= htmlspecialchars($cat->getName()) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="img">Image :</label>
    <input type="file" name="img" id="img">
    <?php if (!empty($errors['img'])): ?>
        <p class="field-error"><?= $errors['img'] ?></p>
    <?php endif; ?>

    <h2>Ingrédients</h2>

    <div id="ingredients">
        <div class="ingredient">
            <input type="text" name="name_ingredient[]" placeholder="Nom">
            <input type="number" name="quantity_ingredient[]" placeholder="Quantité">
            <input type="text" name="unity_ingredient[]" placeholder="Unité">
            <button type="button" class="remove-btn" onclick="removeField(this)">Supprimer</button>
        </div>
    </div>

    <button type="button"  class="btn btn-primary add-btn" onclick="addIngredient()">Ajouter un ingrédient</button>

    <h2>Étapes</h2>
    <div id="steps">
        <div class="step">
            <input type="number" name="order_step[]" placeholder="Ordre">
            <input type="text" name="description_step[]" placeholder="Description">
            <button type="button" class="remove-btn" onclick="removeField(this)">Supprimer</button>
        </div>
    </div>

    <button type="button" class="btn btn-primary add-btn" onclick="addStep()">Ajouter une étape</button>

    <label for="difficulty">Difficulté</label>
    <select name="difficulty" id="difficulty">
        <option value="facile">Facile</option>
        <option value="moyenne">Moyenne</option>
        <option value="difficile">Difficile</option>
    </select>
    <div class="spacer">
        <a href="/recipe/index" class="btn btn-primary">Retour</a>
        <button type="submit" class="btn btn-success">Créer la recette</button>     
    </div>
    
</form>

<script src="/js/recipe-form.js"></script>
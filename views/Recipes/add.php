<h1>Ajouter une recette</h1>

<form action="/recipe/add" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->csrfToken()) ?>">

    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>">
    <?php if (!empty($errors['title'])): ?>
        <p class="error"><?= $errors['title'] ?></p>
    <?php endif; ?>

    <label for="description">Description :</label>
    <textarea name="description" id="description"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    <?php if (!empty($errors['description'])): ?>
        <p class="error"><?= $errors['description'] ?></p>
    <?php endif; ?>

    <label for="duration">Durée (minutes) :</label>
    <input type="number" name="duration" id="duration" value="<?= htmlspecialchars($old['duration'] ?? '') ?>">
    <?php if (!empty($errors['duration'])): ?>
        <p class="error"><?= $errors['duration'] ?></p>
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
        <p class="error"><?= $errors['img'] ?></p>
    <?php endif; ?>

    <h2>Ingrédients</h2>
    <div id="ingredients">
        <div class="ingredient">
            <input type="text" name="name_ingredient[]" placeholder="Nom">
            <input type="number" name="quantity_ingredient[]" placeholder="Quantité">
            <input type="text" name="unity_ingredient[]" placeholder="Unité">
        </div>
    </div>

    <button type="button" onclick="addIngredient()">Ajouter un ingrédient</button>

    <h2>Étapes</h2>
    <div id="steps">
        <div class="step">
            <input type="number" name="order_step[]" placeholder="Ordre">
            <input type="text" name="description_step[]" placeholder="Description">
        </div>
    </div>

    <button type="button" onclick="addStep()">Ajouter une étape</button>

    <button type="submit">Créer la recette</button>
</form>

<script>
function addIngredient() {
    const div = document.createElement('div');
    div.classList.add('ingredient');
    div.innerHTML = `
        <input type="text" name="name_ingredient[]" placeholder="Nom">
        <input type="number" name="quantity_ingredient[]" placeholder="Quantité">
        <input type="text" name="unity_ingredient[]" placeholder="Unité">
    `;
    document.getElementById('ingredients').appendChild(div);
}

function addStep() {
    const div = document.createElement('div');
    div.classList.add('step');
    div.innerHTML = `
        <input type="number" name="order_step[]" placeholder="Ordre">
        <input type="text" name="description_step[]" placeholder="Description">
    `;
    document.getElementById('steps').appendChild(div);
}
</script>
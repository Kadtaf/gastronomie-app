<h1>Liste des recettes</h1>

<div class="add-recipe-container">
    <a href="/recipe/add" class="btn btn-success">Ajouter une recette</a>
</div>

<!-- Filtres -->
<form method="GET" class="filters">
    <select name="category">
        <option value="">Toutes les catégories</option>

        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat->getId() ?>"
                <?= ($filters['category_id'] ?? '') == $cat->getId() ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat->getName()) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="difficulty">
        <option value="">Difficulté</option>
        <option value="facile" <?= ($filters['difficulty'] ?? '') === 'facile' ? 'selected' : '' ?>>Facile</option>
        <option value="moyenne" <?= ($filters['difficulty'] ?? '') === 'moyenne' ? 'selected' : '' ?>>Moyenne</option>
        <option value="difficile" <?= ($filters['difficulty'] ?? '') === 'difficile' ? 'selected' : '' ?>>Difficile</option>
    </select>

    <select name="duration">
        <option value="">Durée</option>
        <option value="15" <?= ($filters['duration'] ?? '') === '15' ? 'selected' : '' ?>>≤ 15 min</option>
        <option value="30" <?= ($filters['duration'] ?? '') === '30' ? 'selected' : '' ?>>≤ 30 min</option>
        <option value="60" <?= ($filters['duration'] ?? '') === '60' ? 'selected' : '' ?>>≤ 1h</option>
    </select>

    <button class="btn btn-primary filter-btn">Filtrer</button>
</form>

<!-- Grille -->
<div class="recipe-grid">
    <?php if (empty($recipes)): ?>
        <p class="no-results">Aucune recette ne correspond à votre recherche.</p>
    <?php endif; ?>
    <?php foreach ($recipes as $recipe): ?>
    <div class="recipe-card-list">

        <!-- Lien principal : image + titre -->
        <a href="/recipe/show/<?= $recipe->getId() ?>">
            <?php $img = $recipe->getFilePathImg() ?: '/img/default.jpg'; ?>

            <img src="<?= htmlspecialchars($img) ?>" alt="Image de la recette">

            <h3><?= htmlspecialchars($recipe->getTitle()) ?></h3>
        </a>

        <!-- Description courte -->
        <p class="excerpt">
            <?= htmlspecialchars(mb_strimwidth($recipe->getDescription(), 0, 80, '...')) ?>
        </p>

        <p><?= htmlspecialchars($recipe->getDuration()) ?> min</p>
        <p><?= htmlspecialchars($recipe->getDifficulty()) ?></p>

        <!-- Boutons CRUD -->
        <div class="card-actions">
            <a href="/recipe/show/<?= $recipe->getId() ?>" class="btn btn-primary">Voir plus</a>
            <a href="/recipe/edit/<?= $recipe->getId() ?>" class="btn btn-warning">Modifier</a>
            <a href="/recipe/delete/<?= $recipe->getId() ?>" class="btn btn-danger"
            onclick="return confirm('Voulez-vous vraiment supprimer cette recette ?')">
            Supprimer
            </a>
        </div>

    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&<?= http_build_query($filters) ?>">Précédent</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&<?= http_build_query($filters) ?>"
            class="<?= $i == $page ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>&<?= http_build_query($filters) ?>">Suivant</a>
    <?php endif; ?>
</div>
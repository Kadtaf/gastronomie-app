<h1>Liste des recettes</h1>

<a href="/recipe/add" class="btn">Ajouter une recette</a>

<ul>
    <?php foreach ($recipes as $recipe): ?>
        <li>
            <a href="/recipe/show/<?= $recipe->getId() ?>">
                <?= htmlspecialchars($recipe->getTitle()) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
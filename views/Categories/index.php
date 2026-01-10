<h1>Liste des catégories</h1>

<ul>
    <?php foreach ($categories as $category): ?>
        <li><?= htmlspecialchars($category->getName()) ?></li>
    <?php endforeach; ?>
</ul>

<a href="/category/add">Ajouter une catégorie</a>
<div class="recipe-card">

    <h1><?= htmlspecialchars($recipe->getTitle()) ?></h1>
    

    <?php $img = $recipe->getFilePathImg() ?: '/img/default.jpg'; ?>
    <img src="<?= htmlspecialchars($img) ?>" alt="Image de la recette" width="300">
    
    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($recipe->getDescription())) ?></p>
    <p><strong>Durée :</strong> <?= htmlspecialchars($recipe->getDuration()) ?> minutes</p>

    <h2>Ingrédients</h2>
    <ul>
        <?php foreach ($ingredients as $ing): ?>
            <li>
                <?= htmlspecialchars($ing->getQuantity()) ?>
                <?= htmlspecialchars($ing->getUnity()) ?>
                de <?= htmlspecialchars($ing->getName()) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Étapes</h2>
    <ol>
        <?php foreach ($steps as $step): ?>
            <li><?= htmlspecialchars($step->getDescription()) ?></li>
        <?php endforeach; ?>
    </ol>
    <div class="card-actions">
            <a href="/recipe/edit/<?= $recipe->getId() ?>" class="btn btn-warning">Modifier</a>
            <a href="/recipe/delete/<?= $recipe->getId() ?>" class="btn btn-danger"
            onclick="return confirm('Voulez-vous vraiment supprimer cette recette ?')">
            Supprimer
            </a>
        </div>
    <a href="/recipe/index" class="btn btn-primary">Retour</a>
</div>
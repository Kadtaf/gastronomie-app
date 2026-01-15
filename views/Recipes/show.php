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

    <a href="/recipe/index">Retour</a>
</div>
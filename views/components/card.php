<div class="card">
    <?php if (!empty($title)): ?>
        <h3 class="card-title"><?= htmlspecialchars($title) ?></h3>
    <?php endif; ?>

    <div class="card-body">
        <?= $slot ?? '' ?>
    </div>
</div>
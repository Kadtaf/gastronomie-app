<?php if (!empty($items)): ?>
<nav class="breadcrumb">
    <?php foreach ($items as $index => $item): ?>
        <?php if (!empty($item['url']) && $index < count($items) - 1): ?>
            <a href="<?= htmlspecialchars($item['url']) ?>">
                <?= htmlspecialchars($item['label']) ?>
            </a>
            <span class="separator">›</span>
        <?php else: ?>
            <span class="current"><?= htmlspecialchars($item['label']) ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
<?php endif; ?>
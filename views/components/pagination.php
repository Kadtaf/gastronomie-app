<?php if ($lastPage > 1): ?>
<nav class="pagination">
    <?php if ($current > 1): ?>
        <a href="?page=<?= $current - 1 ?>" class="page-link">Précédent</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $lastPage; $i++): ?>
        <a href="?page=<?= $i ?>" class="page-link <?= $i == $current ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($current < $lastPage): ?>
        <a href="?page=<?= $current + 1 ?>" class="page-link">Suivant</a>
    <?php endif; ?>
</nav>
<?php $this->component('pagination', $pagination); ?>
<?php endif; ?>
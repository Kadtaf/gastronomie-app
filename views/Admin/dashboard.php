<?php $this->startSection('title'); ?>
Dashboard Admin
<?php $this->endSection(); ?>

<?php $this->startSection('styles'); ?>
<link rel="stylesheet" href="<?= $this->asset('/css/admin_dashboard.css') ?>">
<?php $this->endSection(); ?>

<h1 class="admin-title">Tableau de bord</h1>

<p class="admin-welcome">
    Bonjour <?= htmlspecialchars($_SESSION['user']['firstname']) ?> !
</p>

<div class="admin-grid">
    <a class="admin-card" href="/user/index">
        <h3>Utilisateurs</h3>
        <p>Gérer les comptes et les rôles</p>
    </a>

    <a class="admin-card" href="/recipe/index">
        <h3>Recettes</h3>
        <p>Ajouter, modifier, supprimer</p>
    </a>

    <a class="admin-card" href="/category/index">
        <h3>Catégories</h3>
        <p>Organiser les recettes</p>
    </a>
</div>

<?php $this->startSection('scripts'); ?>
<script src="<?= $this->asset('/js/admin_dashboard.js') ?>"></script>
<?php $this->endSection(); ?>
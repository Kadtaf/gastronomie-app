<?php $this->startSection('title'); ?>
Accueil - Mon site MVC
<?php $this->endSection(); ?>

<?php $this->startSection('styles'); ?>
<link rel="stylesheet" href="/css/home.css">
<?php $this->endSection(); ?>

<h1><?= htmlspecialchars($title ?? 'Bienvenue'); ?></h1>

<?php if ($user): ?>
    <p>Bonjour <?= htmlspecialchars($user['firstname']) ?> !</p>
<?php else: ?>
    <p>Bienvenue visiteur. <a href="/login">Connectez-vous</a></p>
<?php endif; ?>

<?php $this->startSection('scripts'); ?>
<script src="/js/home.js"></script>
<?php $this->endSection(); ?>
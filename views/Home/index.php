<?php $this->startSection('title'); ?>
Accueil - Mon site MVC
<?php $this->endSection(); ?>

<?php $this->startSection('meta'); ?>
<meta name="description" content="Bienvenue sur mon site MVC maison">
<meta name="keywords" content="recettes, cuisine, mvc, php">
<meta property="og:title" content="Accueil">
<meta property="og:type" content="website">
<?php $this->endSection(); ?>

<?php $this->startSection('head'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<?php $this->endSection(); ?>

<?php $this->startSection('beforeBody'); ?>
<div id="loading-overlay"></div>
<?php $this->endSection(); ?>

<?php $this->startSection('styles'); ?>
<link rel="stylesheet" href="<?= $this->asset('/css/home.css') ?>">
<?php $this->endSection(); ?>

<h1><?= htmlspecialchars($title ?? 'Bienvenue'); ?></h1>

<!-- Utilisation de x-alert -->
<?php $this->component('alert', [
    'type' => 'info',
    'message' => 'Bienvenue sur le site !'
]); ?>

<!-- Utilisation de x-card -->
<?php $this->component('card', [
    'title' => 'Présentation',
    'slot'  => '<p>Ceci est une carte affichée grâce au système de composants.</p>'
]); ?>

<!-- Utilisation de x-button -->
<div class="button-container">
    <?php $this->component('button', [
        'variant' => 'primary',
        'label'   => 'Voir les recettes',
        'url'     => '/recipe/index'
        
    ]); ?>
</div>

<?php if ($user): ?>
    <p>Bonjour <?= htmlspecialchars($user['firstname']) ?> !</p>
<?php else: ?>
    <p>Bienvenue visiteur. <a href="/login">Connectez-vous</a></p>
<?php endif; ?>

<?php $this->startSection('scripts'); ?>
<script src="<?= $this->asset('/js/home.js') ?>"></script>
<?php $this->endSection(); ?>

<?php $this->startSection('afterBody'); ?>
<script>
    console.log("Page chargée !");
</script>
<?php $this->endSection(); ?>
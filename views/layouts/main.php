<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- META SEO / OpenGraph -->
    <?php $this->yield('meta'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- TITRE DE LA PAGE -->
    <title><?php $this->yield('title'); ?></title>

    <!-- CSS global versionné -->
    
    <link rel="stylesheet" href="/css/recipes.css">
    <link rel="stylesheet" href="/css/recipe-form.css">
    <link rel="stylesheet" href="/css/design-system.css">

    <!-- CSS spécifique à la vue -->
    <?php $this->yield('styles'); ?>

    <!-- CONTENU SUPPLÉMENTAIRE DANS <head> -->
    <?php $this->yield('head'); ?>
</head>

<body>
    <!-- Composant d'alerte global -->
    
    <?php $this->component('alert', [
    'messages' => \App\Classes\Core\Flash::getAll()
    ]); ?>

    <!-- CONTENU AVANT LE BODY (ex: loader, overlay) -->
    <?php $this->yield('beforeBody'); ?>

    <!-- PARTIALS -->
    <?= $this->includePartial('navbar') ?>
    <?= $this->includePartial('flash') ?>

    <!-- CONTENU PRINCIPAL -->
    <main class="container">
        <?php require $viewFile; ?>
    </main>

    <!-- FOOTER -->
    <?= $this->includePartial('footer') ?>

    <!-- Scripts spécifiques à la vue -->
    <?php $this->yield('scripts'); ?>

    <!-- SCRIPTS APRÈS LE BODY (ex: analytics, trackers) -->
    <?php $this->yield('afterBody'); ?>

    <!-- JS global versionné -->
    <script src="<?= $this->asset('/js/app.js') ?>"></script>
</body>
<?php if (\App\Classes\Core\Flash::has()): ?>
    <?php foreach (\App\Classes\Core\Flash::getAll() as $flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</html>
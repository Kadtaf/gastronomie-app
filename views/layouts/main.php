<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php $this->yield('title'); ?></title>

    <?php $this->yield('styles'); ?>
</head>

<body>

    <?php require dirname(__DIR__) . '/partials/navbar.php'; ?>
    <?php require dirname(__DIR__) . '/partials/flash.php'; ?>

    <main class="container">
        <?php require $viewFile; ?>
    </main>

    <?php require dirname(__DIR__) . '/partials/footer.php'; ?>

    <?php $this->yield('scripts'); ?>
</body>
</html>
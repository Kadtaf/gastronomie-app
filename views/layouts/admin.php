<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php $this->yield('title'); ?></title>

    <link rel="stylesheet" href="/css/admin.css">
    <?php $this->yield('styles'); ?>
</head>

<body class="admin-body">

    <?php require dirname(__DIR__) . '/partials/admin_navbar.php'; ?>

    <main class="admin-container">
        <?php require $viewFile; ?>
    </main>

    <?php require dirname(__DIR__) . '/partials/admin_footer.php'; ?>

    <?php $this->yield('scripts'); ?>
</body>
</html>
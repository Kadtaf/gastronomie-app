<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php $this->yield('title'); ?></title>

    <link rel="stylesheet" href="/css/admin.css">
    <?php $this->yield('styles'); ?>
</head>

<body class="admin-body">

    <?= $this->includePartial('admin_navbar') ?>

    <main class="admin-container">
        <?php require $viewFile; ?>
    </main>

    <?= $this->includePartial('admin_footer') ?>

    <?php $this->yield('scripts'); ?>
</body>
</html>
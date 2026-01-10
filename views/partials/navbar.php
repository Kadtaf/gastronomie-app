<nav class="navbar">
    <a href="/">Accueil</a>
    <a href="/recipe/index">Recettes</a>

    <?php if (isset($_SESSION['user'])): ?>
        <span>Bonjour <?= htmlspecialchars($_SESSION['user']['firstname']) ?></span>

        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <a href="/admin/dashboard">Admin</a>
        <?php endif; ?>

        <a href="/logout">Déconnexion</a>
    <?php else: ?>
        <a href="/login">Connexion</a>
        <a href="/register">Inscription</a>
    <?php endif; ?>
</nav>
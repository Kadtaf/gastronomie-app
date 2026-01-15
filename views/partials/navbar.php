<nav class="navbar">
    <a href="/">Accueil</a>
    <a href="/recipe/index">Recettes</a>
    
    <?php if ($this->isLogged()): ?>
        <span>Bonjour <?= htmlspecialchars($_SESSION['user']['firstname']) ?></span>

        <?php if ($this->isAdmin()): ?>
            <a href="/admin/dashboard">Admin</a>
            <a href="/user/index">Gestion utilisateurs</a>
            <a href="/category/index">Catégories</a>
        <?php endif; ?>

        <a href="/logout">Déconnexion</a>

    <?php else: ?>
        <a href="/login">Connexion</a>
        <a href="/register">Inscription</a>
    <?php endif; ?>
</nav>
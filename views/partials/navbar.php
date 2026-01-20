<nav class="navbar">

    <!-- Zone gauche : LOGO -->
    <div class="nav-left">
        <a href="/" class="logo">
            <img src="/img/logo.png" alt="CookMaster Logo" class="logo-img">
        </a>
    </div>

    <!-- Hamburger au centre -->
    <button class="hamburger" id="hamburger-btn">☰</button>

    <!-- Zone droite : menu mobile + liens utilisateur -->
    <div class="nav-right" id="nav-menu">

        <!-- Liens principaux (affichés en mobile) -->
        <a href="/">Accueil</a>
        <a href="/recipe/index">Recettes</a>

        <div class="dropdown">
            <button class="dropdown-btn">Catégories ▾</button>
            <div class="dropdown-menu">
                <a href="/recipe/index">Toutes les catégories</a>
                <a href="/recipe/index?category=Apéritifs">Apéritifs</a>
                <a href="/recipe/index?category=Entrées">Entrées</a>
                <a href="/recipe/index?category=Plats">Plats</a>
                <a href="/recipe/index?category=Desserts">Desserts</a>
            </div>
        </div>

        <?php if ($this->isLogged()): ?>

            <?php if ($this->isAdmin()): ?>
                <a href="/admin/dashboard">Admin</a>
                <a href="/user/index">Gestion utilisateurs</a>
            <?php endif; ?>

            <span class="username">Bonjour <?= htmlspecialchars($_SESSION['user']['firstname']) ?></span>

            <a href="/logout">Déconnexion</a>

        <?php else: ?>
            <a href="/login">Connexion</a>
            <a href="/register">Inscription</a>
        <?php endif; ?>

    </div>

    <!-- Bouton thème (toujours visible, même en mobile) -->
    <button class="theme-btn" id="theme-toggle">🌓</button>

</nav>
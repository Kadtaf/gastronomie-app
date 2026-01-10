<nav class="admin-navbar">
    <a href="/admin/dashboard">Dashboard</a>
    <a href="/admin/users">Utilisateurs</a>
    <a href="/admin/recipes">Recettes</a>
    <a href="/admin/settings">Paramètres</a>

    <span class="admin-user">
        <?= htmlspecialchars($_SESSION['user']['firstname'] ?? '') ?>
    </span>

    <a href="/logout" class="logout">Déconnexion</a>
</nav>
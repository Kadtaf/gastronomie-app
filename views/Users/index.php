<h1>Liste des utilisateurs</h1>

<a href="/user/add">Ajouter un utilisateur</a>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->getId() ?></td>
                <td><?= htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName()) ?></td>
                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                <td><?= htmlspecialchars($user->getRole()) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
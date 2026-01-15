<h1>Liste des utilisateurs</h1>

<a href="/user/add">Ajouter un utilisateur</a>

<?php $this->component('breadcrumb', [
    'items' => [
        ['label' => 'Admin', 'url' => '/admin/dashboard'],
        ['label' => 'Utilisateurs', 'url' => '/user/index'],
        ['label' => 'Liste']
    ]
]); ?>

<?php $this->component('table', [
    'columns' => ['ID', 'Nom', 'Email', 'Rôle'],
    'fields'  => ['id', 'fullName', 'email', 'role'],
    'data'    => $users
]); ?>

<?php $this->component('pagination', $pagination); ?>
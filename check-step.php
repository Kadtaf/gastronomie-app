<?php

require 'src/Classes/Core/Dbase.php';

$db = \App\Classes\Core\Dbase::getInstance();
$stmt = $db->query('DESCRIBE step');
$columns = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo "Colonnes de la table 'step' :\n";
foreach ($columns as $col) {
    echo "- " . $col['Field'] . " (" . $col['Type'] . ")\n";
}

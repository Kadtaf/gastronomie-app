<?php

require_once 'src/Classes/Core/Dbase.php';

$db = \App\Classes\Core\Dbase::getInstance();
$stmt = $db->query("DESCRIBE step");
$columns = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo "<h2>Colonnes de la table 'step' :</h2>";
echo "<pre>";
print_r($columns);
echo "</pre>";


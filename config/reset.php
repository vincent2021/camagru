<?php
require_once 'database.php';
try {
$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
} catch (Exception $e) {
    echo "Erreur".$e->getMessage();
    exit();
}

$bdd->exec('SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `pictures`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `likes`;
');
echo "BDD Deleted<br>";
?>
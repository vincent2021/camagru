<?php
try {
$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', '42born2code');
echo "BDD Connected.<br>";
} catch (Exception $e) {
    echo "Erreur".$e->getMessage();
    exit();
}
?>
<?php
require_once 'config/database.php';
try {
$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
echo "BDD Connected.<br>";
} catch (Exception $e) {
    echo "Erreur".$e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/bulma.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<title>Back to the 90s</title>
<header>

</header>
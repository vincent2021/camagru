<?php
    function getDB() {
        $DB_DSN = 'mysql:host=localhost;dbname=camagru;charset=utf8';
        $DB_USER = 'root';
        $DB_PASSWORD = '42born2code';
        try {
            $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $bdd;
        } catch (Exception $e) {
                echo "Error: ".$e->getMessage();
                exit();
        }
    }
?>
<?php
require_once "header.php";
require_once "class/userClass.php";
$userClass = new userClass;
if (isset($_GET['key']) && isset($_GET['email'])){
    if ($userClass->confirmUser($_GET['email'], $_GET['key']) == True) {
        echo "Account confirmed. You will be redirected to the login page<br>";
        header('Location: login.php?msg=confirmed');
    } else {
        echo "This link doesn't match any account, please try to register again.<br>";
    }
}
require_once "footer.php";
?>
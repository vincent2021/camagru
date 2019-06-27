<?php
require_once "header.php";
require_once "class/userClass.php";
$userClass = new userClass;
if (isset($_GET['key']) && isset($_GET['email'])) {
    if ($userClass->confirmUser($_GET['email'], $_GET['key']) == True) {
        echo "Account confirmed. You will be redirected to the login page<br>";
        header('Location: login.php?msg=confirmed');
    } else {
        echo "Account already activated or wrong link.<br>";
    }
}
require_once "footer.php";?>
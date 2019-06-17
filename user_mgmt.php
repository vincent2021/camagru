<?php
session_start();
require_once 'class/userClass.php';
$userClass = new userClass();
if (isset($_POST)) {
    foreach($_POST as $value) {
        $value = htmlspecialchars($value);
    }
}
if (isset($_SESSION['uid']) && isset($_POST['full_name'])) {
    $name_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $_POST['full_name']);
    if ($name_check) {
        $ret = $userClass->userChangeName($_POST['full_name'], $_SESSION['uid']);
    } else {
        $ret = "New name doen't match requirements";
    }
    echo ($ret);
}

if (isset($_SESSION['uid']) && isset($_POST['email'])) {
    $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $_POST['email']);
    if ($email_check) {
        $ret = $userClass->userChangeEmail($_POST['email'], $_SESSION['uid']);
    } else {
        $ret = "Please check your e-mail";
    }
    echo ($ret);
}

if (isset($_SESSION['uid']) && (isset($_POST['oldpw']) || isset($_POST['newpw']))) {
    $ret = $userClass->userChangePasswd($_POST, $_SESSION['uid']);
    echo ($ret);
}
?>
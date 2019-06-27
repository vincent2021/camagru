<?php require_once 'header.php';
unset($_SESSION['uid']);
session_destroy();
echo "Logout sucessfull, redirecting to homepage.<br>";
header('Location: index.php');
require_once 'footer.php';?>
<?php 
require_once  'header.php';
require_once 'class/userClass.php';
unset($_SESSION['uid']);
echo "Logout sucessfull, redirecting to homepage.<br>";
header('Location: index.php');
require_once 'footer.php';?>
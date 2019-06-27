<?php require_once 'header.php';
if (isset( $_COOKIE[session_name()]))
setcookie( session_name(), “”, time()-3600, “/” );
$_SESSION = array();
session_destroy();
echo "Logout sucessfull, redirecting to homepage.<br>";
header('Location: index.php');
require_once 'footer.php';?>
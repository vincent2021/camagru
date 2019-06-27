<?php session_start();
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

if (isset($_SESSION['uid']) && (isset($_POST['oldpw']) && isset($_POST['newpw']) && isset($_POST['newpw2']))) {
    $ret = $userClass->userChangePasswd($_POST, $_SESSION['uid']);
    echo ($ret);
}

if (isset($_SESSION['uid']) && isset($_POST['alert'])) {
    $ret = $userClass->userAlertChange($_POST['alert'], $_SESSION['uid']);
    echo ($ret);
}

if (!isset($_SESSION['uid'])) {
    require_once 'header.php';
    if (isset($_POST['email'])) {
        $fdbk = $userClass->userResetLink($_POST['email']);
    } else {
        $fdbk = "";
    }
    echo '<body>
<div class="container">
<br><h1 class="title">Reset your password</h1>
<form class="form" method="POST" action="user_mgmt.php">
    <div class="label">Enter your email</div><input class="input" id="email" type="email" name="email" value=""/> <br>
    <br><span><input class="button is-primary" id="submit" type="submit" name="submit" value="Reset your password"></span>
  </form><br>
  <p>'.$fdbk.'</p><br>
</div>
</body>';
require_once 'footer.php';}?>
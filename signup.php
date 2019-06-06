<?php
require_once 'header.php';
require_once 'class/userClass.php';
$userClass = new userClass();
$fdbk = "";
if (isset($_POST['submit']) && $_POST['submit'] == 'OK') {
    foreach($_POST as $value) {
        $value = htmlspecialchars($value);
    }
    if (isset($_POST['full_name']) && isset($_POST['email']) && isset($_POST['passwd'])) {
        $name_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $_POST['full_name']);
        $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $_POST['email']);
        $passwd_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $_POST['passwd']);
        if ($name_check || $email_check || $passwd_check || strlen($_POST['full_name'] < 4)) {
            $fdbk = $userClass->userSignup($_POST['full_name'], $_POST['email'], $_POST['passwd']);
        } else {
            $fdbk = "Form is not valid.";
        }
    }
}
?>
<body>
<div class="field">
    <form method="POST" action="signup.php">
    <h1 class="title">New user</h1>
    <p>Name: <input id="full_name" type="text" name="full_name" value=""/> <br>
       Email: <input id="email" type="text" name="email" value=""/> <br>
       Password: <input id="passwd" type="password" name="passwd" value=""/><br>
      <input id="submit" type="submit" name="submit" value="OK"></p>
    </form>
    <br><?=$fdbk;?><br>
</div>
</body>
<?php
require_once 'footer.php';
?>

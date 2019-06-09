<?php
require_once 'header.php';
require_once 'class/userClass.php';
$userClass = new userClass();
$fdbk = "";
if (isset($_POST['submit']) && $_POST['submit'] == 'Create a new account') {
    foreach($_POST as $value) {
        $value = htmlspecialchars($value);
    }
    $fdbk = "before checl";
    if (isset($_POST['full_name']) && isset($_POST['email']) && isset($_POST['passwd'])) {
        $name_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $_POST['full_name']);
        $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $_POST['email']);
        $passwd_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $_POST['passwd']);
        if ($name_check && $email_check && $passwd_check) {
            $fdbk = $userClass->userSignup($_POST['full_name'], $_POST['email'], $_POST['passwd']);
        } else {
            $fdbk = "Form is not valid:<br>Password should be at least 6 characters / Name at least 3 characters.";
        }
    }
}
?>
<body>
<div class="container">
    <form class="form" method="POST" action="signup.php">
    <br><h1 class="title">New user</h1>
        <div class="label">Name</div> <input class="input" type="text" id="full_name" name="full_name" value=""/> <br>
        <div class="label">Email</div> <input class="input" type="email" id="email" name="email" value=""/> <br>
        <div class="label">Password</div> <input class="input" type="password" id="passwd" name="passwd" value=""/><br>
        <br><div class="control"><input class="button is-primary" id="submit" type="submit" name="submit" value="Create a new account"></div>
    </form>
    <p><br><?=$fdbk?></p><br><br>
</div>
</body>
<?php
require_once 'footer.php';
?>

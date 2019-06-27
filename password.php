<?php
require_once 'header.php';
require_once 'class/userClass.php';
$userClass = new userClass();
if (isset($_GET)) {
    $fdbk = '';
} else {
    $fdbk = 'Wrong reset link';
}
if (isset($_POST)) {
    foreach($_POST as $value) {
        $value = htmlspecialchars($value);
    }
}
if (isset($_POST['new_pw2']) && isset($_POST['new_pw2']) && isset($_POST['email']) && isset($_POST['key'])) {
    $new_pw_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $_POST['new_pw']);
    if ($new_pw_check && $_POST['new_pw2'] === $_POST['new_pw']) {
        $new_pw = hash('whirlpool', $_POST['new_pw']);
        $fdbk = $userClass->userResetPasswd($new_pw, $_POST['key'], $_POST['email']);
    } else {
        $fdbk = "Form is not valid:<br>Password should be at least 6 characters.";
    }
}
?>
<body>
<div class="container">
    <form class="form" method="POST" action="password.php">
    <br><h1 class="title">Please enter a new password</h1>
        <input type="hidden" name="key" value="<?php echo htmlspecialchars($_GET['key']);?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']);?>">
        <div class="label">New password</div> <input class="input" type="password" id="new_pw" name="new_pw" value=""/>
        <p class="help">Password must contains at least one letter and one number. Minimum length is 6.</p><br>
        <div class="label">Confirm your new password</div> <input class="input" type="password" id="new_pw2" name="new_pw2" value=""/><br>
        <br><div class="control"><input class="button is-primary" id="submit" type="submit" name="submit" value="Create a new account"></div>
    </form>
    <p><br><?=$fdbk?></p><br><br>
</div>
</body>
<?php require_once 'footer.php';?>
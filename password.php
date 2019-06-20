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
if (isset($_POST['old_pw']) && isset($_POST['new_pw']) && isset($_POST['email']) && isset($_POST['key'])) {
    $new_pw_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $_POST['new_pw']);
    if ($new_pw_check) {
        $new_pw = hash('whirlpool', $_POST['new_pw']);
        $old_pw = hash('whirlpool', $_POST['old_pw']);
        $fdbk = $userClass->userResetPasswd($old_pw, $new_pw, $_POST['key'], $_POST['email']);
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
        <div class="label">Old password</div> <input class="input" type="password" id="old_pw" name="old_pw" value=""/><br>
        <div class="label">New password</div> <input class="input" type="password" id="new_pw" name="new_pw" value=""/><br>
        <br><div class="control"><input class="button is-primary" id="submit" type="submit" name="submit" value="Create a new account"></div>
    </form>
    <p><br><?=$fdbk?></p><br><br>
</div>
</body>
<?php require_once 'footer.php';?>
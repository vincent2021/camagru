<?php 
require_once  'header.php';
require_once 'class/userClass.php';
$userClass = new userClass();
$fdbk = "";
if (isset($_POST['submit']) && $_POST['submit'] == 'OK') {
    foreach($_POST as $value) {
        $value = htmlspecialchars($value);
    }
    if (isset($_POST['email']) && isset($_POST['passwd'])) {
        if ($userClass->userLogin($_POST['email'], $_POST['passwd']) == True) {
            header('Location: index.php');
        } else {
            $fdbk = "Login failed. Please check your password or make sure you're registered.";
        }
    }
}
?>
<body>
<div class="container">
<br><h1 class="title">Sign-in</h1>
<form class="form" method="POST" action="login.php">
    <div class="label">Email</div><input class="input" id="email" type="email" name="email" value=""/> <br>
    <div class="label">Password</div><input class ="input" id="passwd" type="password" name="passwd" value=""/><br>
    <br><span><input class="button is-primary" id="submit" type="submit" name="submit" value="OK"></span>
    <span><a class="button" href="signup.php">Sign-up</a></span>
  </form>
  <?=$fdbk?><br>
</div>
</body>
<?php require_once 'footer.php';?>

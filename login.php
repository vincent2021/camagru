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
<h1 class="title">Sign-in</h1>
<form class="form" method="POST" action="login.php">
    <p>Email: <input class="input" id="email" type="email" name="email" value=""/> <br>
      Password: <input class ="input" id="passwd" type="password" name="passwd" value=""/><br>
      <input class="button is-primary" id="submit" type="submit" name="submit" value="OK"></p>
  </form>
  <?=$fdbk?><br>
  <a href="signup.php">Sign-up</a><br>
</div>
</body>
<?php require_once 'footer.php';?>

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
        $fdbk = $userClass->userLogin($_POST['email'], $_POST['passwd']);
    }
}
?>
<body>
<div class="field">
<form class="form" method="POST" action="login.php">
    <h1>Sign-in</h1>
    <p>Email: <input id="email" type="text" name="email" value=""/> <br>
      Password: <input id="passwd" type="password" name="passwd" value=""/><br>
      <input id="submit" type="submit" name="submit" value="OK"></p>
  </form>
  <?=$fdbk?><br>
  <a href="signup.php">Sign-up</a><br>
</div>
</body>
<?php require_once 'footer.php';?>

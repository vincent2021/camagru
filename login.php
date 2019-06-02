<?php 
session_start();
include "auth.php";
foreach($_POST as $value) {
	$value = htmlspecialchars($value);
}
if (isset($_POST['login']) && isset($_POST['passwd']) && auth($_POST['login'], $_POST['passwd'])) {
    $_SESSION['loggued_on_user'] = $_POST['login'];
    header("Location: index.php");
} else if (isset($_POST['login']) && isset($_POST['passwd'])) {
    echo "Connection error.\n";
}
require_once  'header.php';
?>
<body>
<div class="content">
<form class="lform" method="POST" action="login.php">
    <h1>Sign-in</h1>
    <p>Email: <input id="1" type="text" name="login" autocomplete="username" value=""/> <br>
      Password: <input id="2" type="password" name="passwd" autocomplete="current-password" value=""/><br>
      <input id="3" type="submit" name="submit" value="OK"></p>
  </form>
  <a href="create.php">Sign-up</a><br>
</div>
</body>
<?php
require_once 'footer.php';
?>

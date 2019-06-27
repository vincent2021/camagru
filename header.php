<?php
date_default_timezone_set("Europe/Paris");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/bulma.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<title>Camagru</title>
<header>
<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <div class="navbar-item">
            <img src="assets/img/logo.png" height="28">
        </div>
        <a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="false">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
        <div class="navbar-menu" id="navMenu">
            <div class="navbar-start">
                <a class="navbar-item" href="index.php">
                    <span class="icon"><i class="fas fa-home"></i></span><span>Home</span>
                </a>
                <a class="navbar-item" href="library.php">
                <span class="icon"><i class="far fa-eye"></i></span><span>Library</span>
                </a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <?php if (isset($_SESSION['uid'])) {
                            echo '<a class="button is-primary" href="user.php"><strong>My account</strong></a>
                            <a class="button is-light" href="logout.php">Logout</a>';
                        } else {
                            echo '<a class="button is-primary" href="login.php"><strong>Login</strong></a>
                            <a class="button is-light" href="signup.php">Sign up</a>';
                        }?> 
                    </div>
                </div>
        </div>
    </div>
</nav>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', () => {
const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
if ($navbarBurgers.length > 0) {
  $navbarBurgers.forEach( el => {
    el.addEventListener('click', () => {

      const target = el.dataset.target;
      const $target = document.getElementById(target);

      el.classList.toggle('is-active');
      $target.classList.toggle('is-active');

    });
  });
}

});
</script>
</header>
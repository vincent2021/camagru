<?php
date_default_timezone_set("Europe/Paris");
session_start();
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
<title>Camagru - Back to the 90s</title>
<header>
<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <div class="navbar-item">
            <img src="assets/img/logo.png" height="28">
        </div>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="index.php">
                Home
            </a>
            <a class="navbar-item" href="library.php">
                Library
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
</header>
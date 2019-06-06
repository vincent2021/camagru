<?php 
require_once  'header.php';
require_once 'class/userClass.php';
$userClass = new userClass();
if (isset($_SESSION['uid'])) {
    $data = $userClass->userDetail($_SESSION['uid']);
} else {
    header('Location: login.php');
}
?>
<body>
<div class="section">
    <h1 class="title">Full name</h1>
    <p><?=$data[0]?></p><br>
    <h1 class="title">E-mail</h1>
    <p><?=$data[1]?></p><br>
</div>
</body>
<?php require_once 'footer.php';?>

<?php
require_once 'header.php';
require_once 'class/pictureClass.php';
$fdbk = "";
if (isset($_GET['img'])) {
    $pictureClass = new pictureClass($_GET['img']);
    $img_link = $pictureClass->img_link;
} else {
    $img_link = 'assets/img/upload_img.png';
}
if (isset($_POST['submit']) && isset($_POST['comment']) && isset($_SESSION['uid'])) {
    $ret = $pictureClass->commentPicture(htmlspecialchars($_POST['comment']));
    if ($ret == True) {
        $fdbk = "Comment sent";
    } else {
        $fdbk = "Your comment hasn't been send. Please make sure you're connected and try again.";
    }
    unset($_POST['comment']);
    unset($_POST['submit']);
}
?>
<body>
<div class="section">
    <h1 class="title">Picture</h1>
    <div class="container">
        <img src=<?=$img_link?> alt='main image' title='main image'>
    </div>
    <div class="container">
        <form class="form" method="POST" action="picture.php?img=<?=$pictureClass->img_name?>">
            <textarea class="textarea" name="comment" placeholder="write a comment"></textarea>
            <input class="button" type="submit" name="submit" value="Send">
        </form>
        <?=$fdbk?> <br>
        <?php foreach ($pictureClass->getPictureComment() as $comment) {
            echo $comment."<br>";
        }; ?>
    </div> 
</div>
</body>
<?php require_once 'footer.php';?>
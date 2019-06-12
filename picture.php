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
if (isset($_POST['submit']) && strlen($_POST['comment']) > 0 && isset($_SESSION['uid'])) {
    unset($_POST);
    if ($pictureClass->commentPicture(htmlspecialchars($_POST['comment'])) == True) {
        header('Location: picture.php?img='.$pictureClass->img_name);
    } else {
        $fdbk = "Your comment hasn't been send. Please make sure you're connected and try again.";
    }
}
if (isset($_POST['like'])) {
    if ($pictureClass->setLikes()) {
        $fdbk = "Thanks for you like.";
    } else {
        $fdbk = "You've already liked this picture.";
    }
    unset($_POST['like']);
}
?>
<body>
<div class="section">
    <h1 class="title">Picture</h1>
    <div class="container">
        <img src=<?=$img_link?> alt='main image' title='main image'>
    </div>
    <div class="columns">
        <div class="column">
        <form class="form" method="POST" action="picture.php?img=<?=$pictureClass->img_name?>">
            <textarea class="textarea"  name="comment" placeholder="write a comment"></textarea>
            <input class="button" type="submit" name="submit" value="Send">
        </form>
        <?=$fdbk?><br>
        <?php 
            if (($comments = $pictureClass->getPictureComment()) == false) {
                echo "Be the first to comment!<br>";
            } else {
                foreach ($comments as $comment) {
                    echo '<strong>'.$comment['created_at'].' - '.$comment['full_name']." says...</strong><br>";
                    echo $comment['comment_txt']."<br><br>";
                }
            };
        ?>
        </div>
        <div class="column">
            <div class="buttons is-centered">
            <form method="POST" action="picture.php?img=<?=$pictureClass->img_name?>">    
                <input type="submit" name="like"  class="button is-danger is-medium" id="like" value='<?=$pictureClass->getLikes()?> Likes'>
            </form>
            </div>
        </div>
    </div>
</div>
</body>
<?php require_once 'footer.php';?>
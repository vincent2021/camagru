<?php
session_start();
require_once "class/pictureClass.php";
if (isset($_SESSION['uid']) && isset($_POST['img_src'])) {
    $img_name= substr($_POST['img_src'], strrpos($_POST['img_src'], '/') + 1);
    echo $img_name;
    $pictureClass = new pictureClass($img_name);
    if($pictureClass->savePicture()) {
        echo "Picture saved";
    }
}
?>
<?php
session_start();
require_once "class/pictureClass.php";
if (isset($_SESSION['uid']) && isset($_POST['img_src'])) {
    $img_name= substr($_POST['img_src'], strrpos($_POST['img_src'], '/') + 1);
    echo $img_name;
    $pictureClass = new pictureClass($img_name);
    if($pictureClass->savePicture() == True) {
        $old_files = scandir($pictureClass->tmp_dir);
        print_r($old_files);
        foreach($old_files as $file) {
            if (strstr($file, '_'.$_SESSION['uid'].'.png')) {
                unlink($pictureClass->tmp_dir.$file);
            }
        }
    }
}
?>
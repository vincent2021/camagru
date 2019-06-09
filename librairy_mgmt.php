<?php
session_start();
require_once "class/pictureClass.php";
$pictureClass = new pictureClass();
$lib_dir = 'assets/library/';
echo $_POST['img_src'].$_SESSION['uid'];
if (isset($_SESSION['uid']) && isset($_POST['img_src'])) {
    $old_file = substr($_POST['img_src'], strpos($_POST['img_src'], 'assets/tmp/'));
    $new_file = $lib_dir.time().'_'.$_SESSION['uid'].'.png';
    rename($old_file, $new_file);
    $ret = $pictureClass->savePicture($new_file);
    return($ret);
}
?>
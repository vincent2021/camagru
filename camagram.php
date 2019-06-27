<?php
session_start();
if (isset($_SESSION['uid']) && isset($_GET['filter'])) {
    $filter_dir = 'assets/filters/';
    $im = imagecreatefrompng($GLOBALS['HTTP_RAW_POST_DATA']);
    $filter = imagecreatefrompng($filter_dir.$_GET['filter']);
    $dst_x = imagesx($im) / 2 - (imagesx($filter) / 2);
    $dst_y = imagesy($im) / 2 - (imagesy($filter) / 2);
    imagecopy($im, $filter, $dst_x, $dst_y, 0, 0, imagesx($filter), imagesy($filter));
    $preview = 'assets/tmp/'.time().'_'.$_SESSION['uid'].'.png';
    imagepng($im, $preview);
    imagedestroy($im);
    print($preview);
}
?>
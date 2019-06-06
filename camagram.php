<?php
$filter_dir = 'assets/filters/';
$im = imagecreatefrompng($GLOBALS['HTTP_RAW_POST_DATA']);
if (isset($_GET['f'])) {
    $filter = imagecreatefrompng($filter_dir.$_GET['f']);
}
imagecopy($im, $filter, imagesx($im) - (10 + imagesx($filter)), imagesy($im) - (10 + imagesy($filter)), 0, 0, imagesx($filter), imagesy($filter));
$preview = 'assets/tmp/uid_'.time().'.png';
imagepng($im, $preview);
imagedestroy($im);
print($preview);
?>

<?php
header("Content-type: image/png");
$string = "Hello 42";
$im     = imagecreatefrompng($GLOBALS['HTTP_RAW_POST_DATA']);
$orange = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
imagestring($im, 3, $px, 9, $string, $orange);
$snap_file = 'assets/capture/uid_'.time().'.png';
imagepng($im, $snap_file);
echo $snap_file;
imagedestroy($im);
?>

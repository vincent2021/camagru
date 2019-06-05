
<?php
$string = "Hello 42";
$im = imagecreatefrompng($GLOBALS['HTTP_RAW_POST_DATA']);
$filter = imagecreatefrompng('assets/filters/ananas.png');
imagecopy($im, $filter, 30, 150, 0, 0, 450, 234);
$preview = 'assets/tmp/uid_'.time().'.png';
imagepng($im, $preview);
echo $preview;
imagedestroy($im);
?>

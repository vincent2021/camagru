<?php
$lib_dir = 'assets/library/';
if (isset($_POST['img_src'])) {
    $old_file = substr($_POST['img_src'], strpos($_POST['img_src'], 'assets/tmp/'));
    $new_file = $lib_dir.time().'_uid.png';
    $ret = rename($old_file, $new_file);
    echo $old_file."=>".$new_file;
}
?>
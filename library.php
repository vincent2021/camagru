<?php 
require_once  'header.php';?>
<body>
<div class="section">
    <h1 class="title">Library</h1>
    <div class="tile">
     <?php 
        $lib_dir = 'assets/library/';
        $files =  scandir($lib_dir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'png') {
                echo '<div class="box"><img class="lib_pic" src="'.$lib_dir.$file.'" title="'.$file.'" alt="lib_picture"></div>';
            }
        }
        ?>
    </div>
</div>
</body>
<?php require_once 'footer.php';?>
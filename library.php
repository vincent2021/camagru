<?php 
require_once  'header.php';
$nb_items = 6;
if (isset($_GET['p']) && $_GET['p'] != 0) {
    $page = $_GET['p'];
} else {
    $page = 1;
}
if (isset($_GET['msg'])) {
    echo '<script> alert("'.$_GET['msg'].'") </script>';
}
$start_item = ($page - 1) * $nb_items;
$bdd = getDB();
$req = $bdd->prepare('SELECT `path` FROM `pictures` LIMIT :nb_items OFFSET :start_item');
$req->bindParam('nb_items', $nb_items, PDO::PARAM_INT);
$req->bindParam('start_item', $start_item, PDO::PARAM_INT);
try {
    $count_req = $bdd->query('SELECT COUNT(`id`) FROM `pictures`');
    $page_nb = ceil($count_req->fetch()[0] / $nb_items);
    $req->execute();
    while ($result = $req->fetch()) {
        $files[] = $result['path'];
    }
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1146) {
        header('Location: config/setup.php');
    } else {
        echo ("An error occured:". $e);
    }
}
?>
<body>
<div class="section">
    <h1 class="title">Library</h1>
        <?php  
            if (isset($files)) {
                echo '<div class="columns">';
                $items_per_line = 3;
                foreach ($files as $file) {
                    $file_name = substr($file, strrpos($file, '/') + 1);
                    $pic_html = '<div class="column"><a href="picture.php?img='.$file_name.'"><img src="'.$file.'" title="'.$file.'" alt="lib_picture"></a></div>';
                    if ($items_per_line != 0) {
                    echo $pic_html;
                    $items_per_line--;
                    } else {
                        echo '</div><br><div class="columns">';
                        $items_per_line = 2;
                        echo $pic_html;
                    }
                }
                echo '</div>';
            } else {
                echo '<p>Take the first picture!<br>';
            }
        ?>
    <br>
    <nav class="pagination is-centered" role="navigation">
    <a class="pagination-previous" <?php if ($page == 1 || $page_nb == 0) {echo 'disabled';} else {echo 'href="library.php?p='.($page - 1).'"';}?>>Previous</a>
    <a class="pagination-next" <?php if ($page == $page_nb || $page_nb == 0) {echo 'disabled';} else {echo 'href="library.php?p='.($page + 1).'"';}?>>Next page</a>
        <ul class="pagination-list">
            <li><a class="pagination-link <?php if ($page == 1) {echo 'is-current';}?>" href="library.php">1</a></li>
            <?php if ($page != 1 && $page != $page_nb) {
                echo '<li><a class="pagination-link is-current" href="library.php?p='.$page.'">'.$page.'</a></li>';
            }?>
            <li <?php if ($page_nb == 1) {echo 'hidden';}?>><span class="pagination-ellipsis">&hellip;</span></li>
            <li <?php if ($page_nb == 1) {echo 'hidden';}?>>
            <a class="pagination-link <?php if ($page == $page_nb) {echo 'is-current';}?>" <?php if ($page_nb == 0) {echo 'disabled';}?> href="library.php?p=<?php if ($page_nb != 0) {echo $page_nb;}?>" ><?php if ($page_nb != 0) {echo $page_nb;}?></a></li>
        </ul>
    </nav><br>
</div>
</body>
<?php require_once 'footer.php';?>
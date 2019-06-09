<?php 
require_once  'header.php';
$nb_items = 3;
if (isset($_GET['p'])) {
    $start_item = ($_GET['p'] - 1) * $nb_items;
} else {
    $start_item = 0;
}
$bdd = getDB();
$req = $bdd->prepare('SELECT `path` FROM `pictures` LIMIT :nb_items OFFSET :start_item');
$req->bindParam('nb_items', $nb_items, PDO::PARAM_INT);
$req->bindParam('start_item', $start_item, PDO::PARAM_INT);
try {
    $req->execute();
    while ($result = $req->fetch()) {
        $files[] = $result['path'];
    }
    print_r($files);
} catch (PDOException $e) {
    echo ("An error occured: ".$e);
}
?>
<body>
<div class="section">
    <h1 class="title">Library</h1>
    <div class="tile">
     <?php 
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'png') {
                echo '<div class="box"><img class="lib_pic" src="'.$file.'" title="'.$file.'" alt="lib_picture"></div>';
            }
        }
        ?>
    </div>
    <nav class="pagination" role="navigation" aria-label="pagination">
    <a class="pagination-previous">Previous</a>
    <a class="pagination-next">Next page</a>
    <ul class="pagination-list">
        <li>
        <a class="pagination-link is-current" href="library.php?p=1">1</a>
        </li>
        <li>
        <a class="pagination-link" href="library.php?p=2">2</a>
        </li>
        <li>
        <a class="pagination-link" href="library.php?p=3">3</a>
        </li>
    </ul>
    </nav>
</div>
</body>
<?php require_once 'footer.php';?>
<?php 
require_once  'header.php';
$bdd = getDB();
try {

} catch (PDOException $e) {
    echo ("An error occured: ".$e);
}
?>
<body>
<div class="section">
    <h1 class="title">Picture</h1>
</div>
</body>
<?php require_once 'footer.php';?>
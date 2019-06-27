<?php require_once 'header.php';
if (isset($_SESSION['uid'])) {
    $bdd=getDB();
    $req = $bdd->prepare('SELECT `path` FROM `pictures`  WHERE `user_id`=:uid ORDER BY `id` DESC LIMIT 4');
    $req->bindParam('uid', $_SESSION['uid']);
    try {
        $req->execute();
        while ($result = $req->fetch()) {
            $files[] = $result['path'];
        }
    } catch (PDOException $e) {
        echo ("An error occured: ".$e);
    }
} else {
    header('Location: library.php');
}?>
<body>
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="section">
                <h1 class="title">Webcam Feed</h1>
                <video class="box" id="webcam"></video>
                <div class="buttons is-centered">
                    <button class="button is-danger is-medium" id="shoot_button">Take a picture</button>
                    <input id="upload_file" type="file" hidden="hidden" />
                    <button class="button is-medium" id="upload_button">Upload a picture</button>
                </div>
            </div>
            <div class="section">
                <h2 class="title">Filters</h2>
                <div class="control" id="filters">
                    <label class="radio">
                        <input type="radio" name="filter" value="dalma.png" id="filter">
                        <img src="assets/filters/dalma.png" alt="dalma filter" title="dalma filter" width="200px"><br>
                        Dalmatien<br>
                    </label>
                    <label class="radio">
                        <input type="radio" name="filter" value="rainbow.png" id="filter">
                        <img src="assets/filters/rainbow.png" alt="rainbow filter" title="rainbow filter" width="200px"><br>
                        Rainbow<br>
                    </label>
                    <label class="radio">
                        <input type="radio" name="filter" value="dog.png" id="filter">
                        <img src="assets/filters/dog.png" alt="dog filter" title="dog filter" width="200px"><br>
                        Dog<br>
                    </label>
                    <label class="radio">
                        <input type="radio" name="filter" value="cat.png" id="filter" checked>
                        <img src="assets/filters/cat.png" alt="cat filter" title="cat filter" width="100px"><br>
                        Cat<br>
                    </label>
                </div>
                </div>
        </div>
        <div class="column">
            <div class="section">    
                <div class="container">
                    <h1 class="title">Preview</h1> 
                    <canvas class="is-hidden" id="canvas"></canvas>
                    <img class="box" alt="preview" title="preview" id="preview" width="480px" src="assets/img/upload_img.png"/>
                    <div class="buttons"><button class="button is-medium is-primary" id="save_button">Save picture</button></div>
                </div><br>
                <div class="container">
                    <h1 class="title">Your last 4 pictures</h1>
                    <?php echo '<div class="columns">';
                    $items_per_line = 2;
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
                ?>
                </div>
            </div> 
        </div>
    </div>
    <?php if (isset($_SESSION['uid'])) { echo '<script type="text/javascript" src="capture.js"></script>';} ?>
</body>
<?php require_once 'footer.php';?>
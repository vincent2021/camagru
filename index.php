<?php
require_once 'header.php';
?>
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
                        <input type="radio" name="filter" value="90s.png" id="filter" checked>
                        <img src="assets/filters/90s.png" alt="90s filter" title="90s filter" width="100px"><br>
                        Back to the 90s<br>
                    </label>
                    <label class="radio">
                        <input type="radio" name="filter" value="ananas.png" id="filter">
                        <img src="assets/filters/ananas.png" alt="ananas filter" title="ananas filter" width="200px"><br>
                        Ananas<br>
                    </label>
                    <label class="radio">
                        <input type="radio" name="filter" value="walkman.png" id="filter">
                        <img src="assets/filters/walkman.png" alt="walkman filter" title="walkman filter" width="200px"><br>
                        Walman<br>
                    </label>
                    <label class="radio">
                        <input type="radio" name="filter" value="windows.png" id="filter">
                        <img src="assets/filters/windows.png" alt="windows filter" title="windows filter" width="200px"><br>
                        Windows<br>
                    </label>
                </div>
                </div>
        </div>
        <div class="column">
            <div class="section">    
                <div class="container">
                    <h1 class="title">Preview</h1> 
                    <canvas class="is-hidden" id="canvas"></canvas>
                    <img class="box" alt="preview" title="preview" id="preview" width="480px" src="assets/img/upload_img.svg"/>
                    <br><button class="button is-medium is-primary" id="save_button">Save picture</button>
                </div>
            </div> 
        </div>
    </div>
    <script type="text/javascript" src="capture.js"></script>
</body>
<?php
require_once 'footer.php';
?>


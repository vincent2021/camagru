<?php
require_once 'header.php';
?>
<body>
    <div class="columns is-vcentered is-centered">
        <div class="column is-half">
            <div class="section">
                <h1 class="title">Webcam Feed</h1>
                <video class="box" id="webcam"></video>
                <div class="buttons is-centered">
                    <button class="button is-danger is-large" id="shoot_button">Take a picture</button>
                </div>
            </div>
            <div class="section">    
                <div class="container">
                    <h1 class="title">Preview</h1>
                    <canvas id="canvas" style="display:none"></canvas>
                    <img class="box" id="preview" style="align:center"/> 
                </div>
            </div> 
        </div>
            <script type="text/javascript" src="capture.js"></script>
        <div class="column">
            <h2 class="title">Filters</h2>
        </div>
    </div>
</body>
<?php
require_once 'footer.php';
?>


<?php
require_once 'header.php';
?>
<body>
    <video id="webcam"></video><br>
    <button class="button" id="webcam_start">Prendre une photo</button>
    <br>
    <canvas id="webcam_canvas"></canvas>
    <img id="snap" src=''>
    <script type="text/javascript" src="capture.js"></script>
</body>
<?php
require_once 'footer.php';
?>


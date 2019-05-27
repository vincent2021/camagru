(function() {

    var streaming = false,
        video        = document.querySelector('#webcam'),
        canvas       = document.querySelector('#webcam_canvas'),
        photo        = document.querySelector('#webcam_img'),
        startbutton  = document.querySelector('#webcam_start'),
        width = 640,
        height = 0;
    
    navigator.mediaDevices.getUserMedia(
      {
        video: true,
        audio: false
      }).then(
      function(stream) {
          video.srcObject = stream;
          video.onloadedmetadata = function() {
            video.play();
          };
      }).catch(
      function(err) {
        console.log("An error occured! " + err);
      });
    
    video.addEventListener('canplay', function(ev){
      if (!streaming) {
        height = video.videoHeight / (video.videoWidth/width);
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        streaming = true;
      }
    }, false);
    
    function takepicture() {
      canvas.width = width;
      canvas.height = height;
      canvas.getContext('2d').drawImage(video, 0, 0, width, height);
      var data = canvas.toDataURL('image/png');
    }
    
    startbutton.addEventListener('click', function(ev){
        takepicture();
      ev.preventDefault();
    }, false);
    
})();
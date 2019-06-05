(function() {

    var streaming = false,
        video        = document.querySelector('#webcam'),
        canvas       = document.querySelector('#webcam_canvas'),
        photo        = document.querySelector('#webcam_img'),
        startbutton  = document.querySelector('#webcam_start'),
        width = 320,
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
      var xhr = getXMLHttpRequest();
      xhr.onreadystatechange = function() {//Call a function when the state changes.
        if(xhr.readyState == 4 && xhr.status == 200) {
            snap_file = xhr.responseText;
            console.log(xhr.responseText)          
        }
      }
      xhr.open('POST', 'camagram.php', true);
      xhr.setRequestHeader("Content-Type", "image/png");
      xhr.send(data);
      return (1);
    }
    
    function reload_snap(){
      snap = new Image();
      snap.src = snap_file;
      setTimeout(function() {
        canvas.getContext('2d').drawImage(snap, 0, 0, width, height);}, 800);
    }

    startbutton.addEventListener('click', function(ev){
        if (takepicture() == 1) {
          reload_snap();
        }
      ev.preventDefault();
    }, false);

    function getXMLHttpRequest() {
      var xhr = null;
      
      if (window.XMLHttpRequest || window.ActiveXObject) {
          if (window.ActiveXObject) {
              try {
                  xhr = new ActiveXObject("Msxml2.XMLHTTP");
              } catch(e) {
                  xhr = new ActiveXObject("Microsoft.XMLHTTP");
              }
          } else {
              xhr = new XMLHttpRequest(); 
          }
      } else {
          alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
          return null;
      }
      
      return xhr;
  }
    
})();
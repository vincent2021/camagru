(function() {

    var streaming = false,
        video        = document.querySelector('#webcam'),
        canvas       = document.querySelector('#canvas'),
        startbutton  = document.querySelector('#shoot_button'),
        width = 480,
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
      xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("preview").src = xhr.response;
        }
      }
      xhr.open('POST', 'camagram.php', true);
      xhr.setRequestHeader("Content-Type", "image/png");
      xhr.send(data);
    }

    startbutton.addEventListener('click', function(){takepicture();});

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
          alert("Your browser doesn't support XMLHTTPRequest...");
          return null;
      }
      
      return xhr;
  }
    
})();
(function() {

    var streaming = false,
        video = document.querySelector('#webcam'),
        canvas = document.querySelector('#canvas'),
        shoot = document.querySelector('#shoot_button'),
        upload = document.querySelector('#upload_button'),
        save = document.querySelector('#save_button'),
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
      sendPicture(data, getFilter());
    }

    function uploadPicture() {
      file_input = document.querySelector('#upload_file');
      file_input.click();
      file_input.addEventListener('change', function() {
          reader = new FileReader();
          reader.readAsDataURL(file_input.files[0]);
          reader.addEventListener('load', function() {
              sendPicture(reader.result, getFilter());
          });
      });
    }

    function sendPicture(data, filter) {
      var xhr = getXMLHttpRequest();
      xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("preview").src = xhr.response;
        }
      }
      xhr.open('POST', 'camagram.php?filter=' + filter, true);
      xhr.setRequestHeader('Content-Type', 'image/png');
      xhr.send(data);
    }

    function getFilter() {
      radioBtn = document.getElementsByName('filter');
      for (i = 0; i < radioBtn.length ; i++) {
        if (radioBtn[i].type == 'radio' && radioBtn[i].checked) {
          return (radioBtn[i].value);
        }
      }
    }

    shoot.addEventListener('click', function(){
      takepicture(getFilter());
    });

    upload.addEventListener('click', function(){
      uploadPicture();
    });

    save.addEventListener('click', function(){
      var xhr = getXMLHttpRequest();
      var img_src = document.getElementById("preview").src;
      var params = 'img_src=' + img_src;
      xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.response);
        }
      }
      xhr.open('POST', 'librairy_mgmt.php', true);;
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send(params);
    });

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
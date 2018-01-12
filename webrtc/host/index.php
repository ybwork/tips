<!DOCTYPE html>
<html>

<head>

<meta name="keywords" content="JavaScript, WebRTC" />
<meta name="description" content="WebRTC codelab" />
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1">

<title>WebRTC codelab: step 2</title>

<style>
</style>

    <script src='js/lib/adapter.js'></script>

</head>

<body>

<video/>

<script>
    // Создаём вход для разных браузеров
    navigator.getUserMedia = navigator.getUserMedia ||
  navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    // Задали с чем будем работать
    var constraints = {video: true};

    function successCallback(localMediaStream) {
      window.stream = localMediaStream;
      var video = document.querySelector("video");
      video.src = window.URL.createObjectURL(localMediaStream);
      video.play();
    }

    function errorCallback(error){
      console.log("navigator.getUserMedia error: ", error);
    }

    // Запуск
    navigator.getUserMedia(constraints, successCallback, errorCallback);
</script>

</body>

</html>

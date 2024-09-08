<html>
<head>
  <title>Wesele Aleksandry i Roberta</title>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
      body {
          font-family: Arial, sans-serif;
          padding: 0;
          margin: 0;
          background-color: rgb(249, 250, 251);
      }

      .overlay {
          position: fixed;
          top: 0;
          left: 0;
          width: 100vw;
          height: 100vh;
          background-color: rgb(251, 251, 251);
          background-image: url('background.jpg');
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
          opacity: 1.0;
          transition: opacity 700ms;
      }
  </style>
</head>
<body>
<div class="overlay">
</div>
<script>
  function whenReady(callback) {
    if (window.document.readyState !== 'loading') {
      callback();
    } else {
      window.addEventListener("DOMContentLoaded", () => {
        callback();
      });
    }
  }
</script>
<div class="all" style="display:none;">
  @include('photos')
  @include('upload')
</div>
<script>
  whenReady(() => {
    setTimeout(() => {
      document.querySelector(".all").style.display = "block";
      document.querySelector(".overlay").style.opacity = '0.0';
      document.querySelector(".overlay").style.pointerEvents = 'none';
    }, 1000);
  });
</script>
</body>
</html>

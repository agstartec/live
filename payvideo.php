

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>player</title>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display:flex;flex-direction:column;">
        <?php
        // Verifica se a senha está armazenada na sessão
        if (isset($_SESSION['senha'])) {
            $senhaRecuperada = $_SESSION['senha'];
            echo '<input type="hidden" id="autenticacao" value="'.$senhaRecuperada.'">';
        }

        ?>
    
    <!-- Create a video element -->
    <video style="width:100%;" id="video" controls></video>
    <button style:"min-width:200px; width:200px" id="playButton">Play Video</button>

    <!-- Use hls.js to create a player and load the .m3u8 file -->
    <script>
        let autenticacao = document.getElementById('autenticacao').value;
        console.log(autenticacao);
var video = document.getElementById('video');
var playButton = document.getElementById('playButton');
function playVideo() {
  if(Hls.isSupported()) {
    var hls = new Hls({
      liveSyncDurationCount: 2, // Ajustar para sincronização próxima do ao vivo
      liveMaxLatencyDurationCount: 3, // Ajustar o atraso máximo tolerável
      maxLiveSyncPlaybackRate: 1.5 // Taxa de reprodução para alcançar o ponto ao vivo rapidamente
    });

    hls.loadSource(`https://camera.casaforteprojetos.com/${autenticacao}.m3u8`);
    hls.attachMedia(video);

    hls.on(Hls.Events.MANIFEST_PARSED, function() {
      console.log('Manifest parsed, starting video playback');
      hls.startLoad(0); // Start loading from the live edge
      video.play().then(() => {
        console.log('Video started playing');
      }).catch(error => {
        console.error('Error attempting to play video:', error);
      });
    });
    hls.on(Hls.Events.LEVEL_LOADED, function(event, data) {
      var latency = data.details.totalduration - (hls.streamController.lastCurrentTime - hls.streamController.startPosition);
      console.log('Current latency: ' + latency + ' seconds');
    });

    // Seek to the latest segment
    hls.on(Hls.Events.FRAG_LOADED, function(event, data) {
      if (!hls.startPosition) {
        hls.startPosition = -1; // Seek to the latest position
      }
    });

  } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
    video.src = `https://camera.casaforteprojetos.com/${autenticacao}.m3u8`;
    video.addEventListener('loadedmetadata', function() {
      console.log('Metadata loaded, starting video playback');
      video.currentTime = video.duration - 5; // Pula para os últimos 10 segundos
      video.play().then(() => {
        console.log('Video started playing');
      }).catch(error => {
        console.error('Error attempting to play video:', error);
      });
    });
  }
}

playButton.addEventListener('click', playVideo);
    </script>
</body>
</html>

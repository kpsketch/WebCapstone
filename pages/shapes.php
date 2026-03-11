<!DOCTYPE html>
<html>
<head>
  <title>Shapes - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1 class="page-title">Learn Shapes</h1>
<p class="page-subtitle">Click any shape to see it bigger and hear the sound.</p>

<div class="grid">
  <?php
    $shapes = ["arrow","circle","crescent","diamond","go","heart","hexagon","no","oval","pentagon","plus","rectangle","square","star","stop","triangle","yes"];
    foreach ($shapes as $s) {
      echo "
        <div class='card' onclick=\"showItem('$s')\">
          <img src='../assets/shapes-images/$s.png' alt='$s'>
          <div class='label'>".ucfirst($s)."</div>
        </div>
      ";
    }
  ?>
</div>

<div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
  <div class="popup-box" onclick="event.stopPropagation()">
    <img id="popupImg" src="" alt="Shape">
    <div id="popupText" class="popup-text"></div>
  </div>
</div>

<audio id="sound" preload="auto"></audio>

<p><a class="back-link" href="../index.php">← Back to Home</a></p>

<script>
function showItem(name) {
  const overlay = document.getElementById("popupOverlay");
  document.getElementById("popupImg").src = `../assets/shapes-images/${name}.png`;
  document.getElementById("popupText").textContent = name.charAt(0).toUpperCase() + name.slice(1);
  overlay.style.display = "flex";

  playSound(`../assets/shapes-sounds/${name}.wav`, closePopup);
}

function playSound(src, onEnd) {
  const sound = document.getElementById("sound");
  sound.pause();
  sound.currentTime = 0;
  sound.onended = null;

  sound.src = src;
  sound.load();
  sound.onended = () => onEnd && onEnd();

  sound.play().catch(() => setTimeout(() => onEnd && onEnd(), 600));
}

function closePopup() {
  const overlay = document.getElementById("popupOverlay");
  const sound = document.getElementById("sound");
  overlay.style.display = "none";
  sound.pause();
  sound.currentTime = 0;
}
</script>

</body>
</html>
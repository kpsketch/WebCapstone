<!DOCTYPE html>
<html>
<head>
  <title>Colors - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1 class="page-title">Learn Colors</h1>
<p class="page-subtitle">Click any color to see it bigger and hear the sound.</p>

<div class="grid">
  <?php
    $colors = ["black","blue","brown","green","grey","orange","pink","purple","red","yellow"];
    foreach ($colors as $c) {
      echo "
        <div class='card' onclick=\"showItem('$c')\">
          <img src='../assets/colors-images/$c.png' alt='$c'>
          <div class='label'>".ucfirst($c)."</div>
        </div>
      ";
    }
  ?>
</div>

<div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
  <div class="popup-box" onclick="event.stopPropagation()">
    <img id="popupImg" src="" alt="Color">
    <div id="popupText" class="popup-text"></div>
  </div>
</div>

<audio id="sound" preload="auto"></audio>

<p><a class="back-link" href="../index.php">← Back to Home</a></p>

<script>
function showItem(name) {
  const overlay = document.getElementById("popupOverlay");
  document.getElementById("popupImg").src = `../assets/colors-images/${name}.png`;
  document.getElementById("popupText").textContent = name.charAt(0).toUpperCase() + name.slice(1);
  overlay.style.display = "flex";

  playSound(`../assets/colors-sounds/${name}.wav`, closePopup);
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
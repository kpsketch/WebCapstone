<!DOCTYPE html>
<html>
<head>
  <title>ABC - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="page-panel">

  <h1 class="page-title">Learn ABC (A–Z)</h1>
  <p class="page-subtitle">Click any letter to see it bigger and hear the sound.</p>

  <div class="grid">
    <?php
      for ($i = 97; $i <= 122; $i++) {
        $letter = chr($i);
        echo "
          <div class='card' onclick=\"showItem('$letter')\">
            <img src='../assets/images/$letter.png' alt='$letter'>
            <div class='label'>".strtoupper($letter)."</div>
          </div>
        ";
      }
    ?>
  </div>

  <!-- POPUP -->
  <div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
    <div class="popup-box" onclick="event.stopPropagation()">
      <img id="popupImg" src="" alt="Popup">
      <div id="popupText" class="popup-text"></div>
    </div>
  </div>

  <audio id="sound" preload="auto"></audio>

  <p><a class="back-link" href="../index.php">← Back to Home</a></p>

</div>

<script>
function showItem(letter) {
  const overlay = document.getElementById("popupOverlay");
  const popupImg = document.getElementById("popupImg");
  const popupText = document.getElementById("popupText");

  popupImg.src = `../assets/images/${letter}.png`;
  popupText.textContent = letter.toUpperCase();
  overlay.style.display = "flex";

  playSound(`../assets/audio/${letter}.wav`, closePopup);
}

function playSound(src, onEnd) {
  const sound = document.getElementById("sound");
  sound.pause();
  sound.currentTime = 0;
  sound.onended = null;

  sound.src = src;
  sound.load();
  sound.onended = () => onEnd && onEnd();

  sound.play().catch(() => {
    setTimeout(() => onEnd && onEnd(), 600);
  });
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
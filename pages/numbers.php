<!DOCTYPE html>
<html>
<head>
  <title>Numbers - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Learn Numbers (1–20)</h1>
<p>Click any number to hear the sound.</p>

<div class="grid">
  <?php
    for ($i = 1; $i <= 20; $i++) {
      echo "
        <div class='card' onclick=\"showPopup($i)\">
          <img src='../assets/numbers/images/$i.png' alt='Number $i'>
        </div>
      ";
    }
  ?>
</div>

<!-- Popup -->
<div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
  <div class="popup-box" onclick="event.stopPropagation()">
    <img id="popupImg" src="" alt="Popup Number">
  </div>
</div>

<audio id="sound"></audio>

<p><a href="../index.php">← Back to Home</a></p>

<script>
function showPopup(num) {
  const overlay = document.getElementById("popupOverlay");
  const popupImg = document.getElementById("popupImg");
  const sound = document.getElementById("sound");

  popupImg.src = `../assets/numbers/images/${num}.png`;
  overlay.style.display = "flex";

  sound.src = `../assets/numbers/images/numbers/sounds/${num}.wav`;
  sound.currentTime = 0;
  sound.play();

  sound.onended = () => closePopup();
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

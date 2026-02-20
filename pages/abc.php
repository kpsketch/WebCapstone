<!DOCTYPE html>
<html>
<head>
  <title>ABC - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Learn ABC (A–Z)</h1>
<p>Click any image to hear the sound.</p>

<!-- POPUP OVERLAY -->
<div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
  <div class="popup-box" onclick="event.stopPropagation()">
    <img id="popupImg" src="" alt="Popup Image">
    <p id="popupText"></p>
  </div>
</div>

<!-- GRID -->
<div class="grid">
  <?php
    for ($i = 97; $i <= 122; $i++) {
      $letter = chr($i);
      echo "
        <div class='card' onclick=\"showPopup('$letter')\">
          <img src='../assets/images/$letter.png' alt='$letter'>
          <div class='letter-label'>".strtoupper($letter)."</div>
        </div>
      ";
    }
  ?>
</div>

<audio id="sound"></audio>

<p><a href="../index.php">← Back to Home</a></p>

<script>
function showPopup(letter) {
  const overlay = document.getElementById("popupOverlay");
  const popupImg = document.getElementById("popupImg");
  const popupText = document.getElementById("popupText");
  const sound = document.getElementById("sound");

  // set image + text
  popupImg.src = `../assets/images/${letter}.png`;
  popupText.innerText = letter.toUpperCase();

  // show popup
  overlay.style.display = "flex";

  // play sound
  sound.src = `../assets/audio/${letter}.wav`;
  sound.currentTime = 0;
sound.play();

sound.play();

  sound.play();

  // auto close when sound ends
  sound.onended = () => {
    closePopup();
  };
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

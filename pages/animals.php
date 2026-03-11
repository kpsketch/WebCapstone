<!DOCTYPE html>
<html>
<head>
  <title>Animals - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="page-panel">


<h1 class="page-title">Animal Sounds</h1>
<p class="page-subtitle">Click any animal to see it bigger and hear the sound.</p>

<div class="grid">
  <?php
    $animals = [
      "alligator","bear","camel","cat","chicken","cow",
      "deer","dog","duck","elephant","fox","frog",
      "giraffe","hippo","horse","ladybug","lion","monkey",
      "mouse","owl","panda","peacock","penguin","pig",
      "sheep","snake","tiger","zebra"
    ];

    foreach ($animals as $a) {
      echo "
        <div class='card' onclick=\"showAnimal('$a')\">
        
          <img src='../assets/animal-images/$a.png' alt='$a'>
          <div class='label'>".ucfirst($a)."</div>
        </div>
      ";
    }
  ?>
</div>

<!-- POPUP OVERLAY -->
<div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
  <div class="popup-box" onclick="event.stopPropagation()">
    <div id="popupLetter" class="popup-letter"></div>
    <img id="popupImg" src="" alt="Animal">
    <div id="popupText" class="popup-text"></div>
  </div>
</div>

<audio id="sound" preload="auto"></audio>

<p><a class="back-link" href="../index.php">← Back to Home</a></p>

  </div>

<script>
function showAnimal(name) {
  const overlay = document.getElementById("popupOverlay");
  const popupImg = document.getElementById("popupImg");
  const popupText = document.getElementById("popupText");
  const popupLetter = document.getElementById("popupLetter");
  const sound = document.getElementById("sound");

  // ✅ IMPORTANT: use ../ not ...
  popupImg.src = `../assets/animal-images/${name}.png`;
  popupText.textContent = name.charAt(0).toUpperCase() + name.slice(1);
  popupLetter.textContent = name.charAt(0).toUpperCase();

  overlay.style.display = "flex";

  sound.onended = () => closePopup();
  sound.src = `../assets/animal-sounds/${name}.wav`;
  sound.currentTime = 0;

  sound.play().catch(() => {
    // if something blocks audio or file missing, auto-close after 1 sec
    setTimeout(() => closePopup(), 1000);
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

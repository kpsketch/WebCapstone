<!DOCTYPE html>
<html>
<head>
  <title>Numbers - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1 class="page-title">Learn Numbers (1–20)</h1>
<p class="page-subtitle">Click any number to see it bigger and hear the sound.</p>

<div class="grid">
  <?php
    for ($n = 1; $n <= 20; $n++) {
      echo "
        <div class='card' onclick=\"showItem('$n')\">
          <img src='../assets/numbers/images/$n.png' alt='$n'>
          <div class='label'>$n</div>
        </div>
      ";
    }
  ?>
</div>

<!-- POPUP -->
<div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
  <div class="popup-box" onclick="event.stopPropagation()">
    <img id="popupImg" src="" alt="Number">
    <div id="popupText" class="popup-text"></div>
  </div>
</div>

<audio id="sound" preload="auto"></audio>

<p><a class="back-link" href="../index.php">← Back to Home</a></p>

<script>
function showItem(num) {
  const overlay = document.getElementById("popupOverlay");
  const popupImg = document.getElementById("popupImg");
  const popupText = document.getElementById("popupText");

  popupImg.src = `../assets/numbers/images/${num}.png`;
  popupText.textContent = num;
  overlay.style.display = "flex";

  const audioPath = `../assets/numbers/sounds/${num}.mp3`;

  // play twice, then wait 2.5 seconds, then close
  playSoundTwice(audioPath, 2500, closePopup);
}

async function playSoundTwice(src, delayMs, onDone) {
  try {
    await playOnce(src);  // 1st time
    await playOnce(src);  // 2nd time

    setTimeout(() => {
      if (onDone) onDone();
    }, delayMs);

  } catch (err) {
    console.log("Audio issue:", src, err);
    // if something fails, close after short delay
    setTimeout(() => onDone && onDone(), 800);
  }
}

function playOnce(src) {
  return new Promise((resolve, reject) => {
    const sound = document.getElementById("sound");

    sound.pause();
    sound.currentTime = 0;
    sound.onended = null;

    // small cache buster so browser always loads correctly
    sound.src = src + "?v=" + Date.now();
    sound.load();

    sound.onended = () => resolve();

    sound.play().catch((err) => reject(err));
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
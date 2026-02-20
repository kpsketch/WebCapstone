<!DOCTYPE html>
<html>
<head>
  <title>Colors - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1 class="page-title">Learn Colors</h1>
<p class="page-subtitle">Click any color to see it bigger and hear the sound.</p>

<?php
  $colors = [
    "black","blue","brown","green","grey",
    "orange","pink","purple","red","yellow"
  ];
?>

<div class="grid">
  <?php foreach ($colors as $c): ?>
    <div class="card" onclick="showItem('<?php echo $c; ?>','colors-images','colors-sounds')">
      <img src="../assets/colors-images/<?php echo $c; ?>.png" alt="<?php echo $c; ?>">
      <div class="label"><?php echo ucfirst($c); ?></div>
    </div>
  <?php endforeach; ?>
</div>

<!-- POPUP -->
<div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
  <div class="popup-box" onclick="event.stopPropagation()">
    <div id="popupLetter" class="popup-letter"></div>
    <img id="popupImg" src="" alt="Color">
    <div id="popupText" class="popup-text"></div>
  </div>
</div>

<audio id="sound" preload="auto"></audio>

<p><a class="back-link" href="../index.php">← Back to Home</a></p>

<script>
const overlay = document.getElementById("popupOverlay");
const popupImg = document.getElementById("popupImg");
const popupText = document.getElementById("popupText");
const popupLetter = document.getElementById("popupLetter");
const sound = document.getElementById("sound");

function cap(word){
  return word.charAt(0).toUpperCase() + word.slice(1);
}

function showItem(name, imgFolder, sndFolder) {
  // popup content
  popupImg.src = `../assets/${imgFolder}/${name}.png`;
  popupText.textContent = cap(name);
  popupLetter.textContent = name.charAt(0).toUpperCase();
  overlay.style.display = "flex";

  // audio: prevent clipped start ✅
  sound.pause();
  sound.currentTime = 0;
  sound.onended = closePopup;
  sound.onerror = () => setTimeout(closePopup, 1000);

  sound.src = `../assets/${sndFolder}/${name}.wav`;
  sound.load();

  sound.oncanplaythrough = () => {
    sound.oncanplaythrough = null;
    setTimeout(() => {
      sound.play().catch(() => setTimeout(closePopup, 1000));
    }, 80);
  };
}

function closePopup() {
  overlay.style.display = "none";
  sound.pause();
  sound.currentTime = 0;
}
</script>

</body>
</html>

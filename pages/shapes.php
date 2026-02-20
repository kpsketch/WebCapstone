<!DOCTYPE html>
<html>
<head>
  <title>Shapes - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1 class="page-title">Learn Shapes</h1>
<p class="page-subtitle">Click any shape to see it bigger and hear the sound.</p>

<?php
  $shapes = [
    "arrow","circle","crescent","diamond","go",
    "heart","hexagon","no","oval","pentagon",
    "plus","rectangle","square","star","stop",
    "triangle","yes"
  ];
?>

<div class="grid">
  <?php foreach ($shapes as $s): ?>
    <div class="card" onclick="showItem('<?php echo $s; ?>','shapes-images','shapes-sounds')">
      <img src="../assets/shapes-images/<?php echo $s; ?>.png" alt="<?php echo $s; ?>">
      <div class="label"><?php echo ucfirst($s); ?></div>
    </div>
  <?php endforeach; ?>
</div>

<!-- POPUP -->
<div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
  <div class="popup-box" onclick="event.stopPropagation()">
    <div id="popupLetter" class="popup-letter"></div>
    <img id="popupImg" src="" alt="Shape">
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

<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Shapes - Kids Learning Hub</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="inner-topbar">
  <div class="header-inner">

    <div class="header-left">
     <div class="site-brand">
  <img src="../assets/logo.png" class="site-logo" alt="Logo">
  
  <div>
    <div class="site-title">Kids Learning Hub</div>
    <div class="site-tagline">Learn letters, numbers, colors, shapes and animals</div>
  </div>
</div>

    </div>

    <div class="header-center">
      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-greet">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></div>
      <?php endif; ?>
    </div>

    <div class="header-right">
      <div class="right-main">
        <div class="topbar-links">
          <a href="../index.php">Home</a>

          <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../my_results.php">My Results</a>
            <a href="../logout.php">Logout</a>
          <?php else: ?>
            <a href="../login.php">Login</a>
            <a href="../register.php">Register</a>
          <?php endif; ?>
        </div>
      </div>

     <div class="social-icons">
  <a href="#"><i class="fab fa-facebook-f"></i></a>
  <a href="#"><i class="fab fa-instagram"></i></a>
  <a href="#"><i class="fab fa-youtube"></i></a>
</div>
    </div>

  </div>
</header>

<div class="page-panel">

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
    <div class="popup-box" onclick="replaySound(); event.stopPropagation()">
      <img id="popupImg" src="" alt="Shape">
      <div id="popupText" class="popup-text"></div>

      <div class="popup-nav">
        <button id="prevBtn" type="button" onclick="showPrevious()">← Back</button>
        <button id="nextBtn" type="button" onclick="showNext()">Next →</button>
      </div>
    </div>
  </div>

  <audio id="sound" preload="auto"></audio>

  <div class="page-arrows">
    <a class="arrow-btn" href="colors.php">← Back</a>
    <a class="arrow-btn" href="animals.php">Next →</a>
  </div>

  <div class="center-home-link">
    <a href="../index.php">Back to Home</a>
  </div>

</div>

<script>
const shapes = ["arrow","circle","crescent","diamond","go","heart","hexagon","no","oval","pentagon","plus","rectangle","square","star","stop","triangle","yes"];
let currentIndex = 0;

function showItem(name) {
  currentIndex = shapes.indexOf(name);
  updatePopup();
}

function updatePopup() {
  const name = shapes[currentIndex];

  document.getElementById("popupImg").src = `../assets/shapes-images/${name}.png`;
  document.getElementById("popupText").textContent = name.charAt(0).toUpperCase() + name.slice(1);
  document.getElementById("popupOverlay").style.display = "flex";

  document.getElementById("prevBtn").disabled = currentIndex === 0;
  document.getElementById("nextBtn").disabled = currentIndex === shapes.length - 1;

  playSound();
}

function playSound() {
  const name = shapes[currentIndex];
  const sound = document.getElementById("sound");

  sound.pause();
  sound.currentTime = 0;
  sound.src = `../assets/shapes-sounds/${name}.wav?v=` + Date.now();
  sound.load();
  sound.play().catch(() => {});
}

function replaySound() {
  playSound();
}

function showPrevious() {
  if (currentIndex > 0) {
    currentIndex--;
    updatePopup();
  }
}

function showNext() {
  if (currentIndex < shapes.length - 1) {
    currentIndex++;
    updatePopup();
  }
}

function closePopup() {
  document.getElementById("popupOverlay").style.display = "none";
  const sound = document.getElementById("sound");
  sound.pause();
  sound.currentTime = 0;
}
</script>

</body>
</html>
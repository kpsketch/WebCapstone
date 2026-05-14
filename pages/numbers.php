<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Numbers - Kids Learning Hub</title>
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

  <h1 class="page-title">Learn Numbers (1–20)</h1>
  <p class="page-subtitle">Click any number to see it bigger and hear the sound.</p>

  <div class="grid">
    <?php
      for ($n = 1; $n <= 20; $n++) {
        echo "
          <div class='card' onclick=\"showItem($n)\">
            <img src='../assets/numbers/images/$n.png' alt='$n'>
          </div>
        ";
      }
    ?>
  </div>

  <div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
    <div class="popup-box" onclick="replaySound(); event.stopPropagation()">
      <img id="popupImg" src="" alt="Number">

      <div class="popup-nav">
        <button id="prevBtn" type="button" onclick="showPrevious()">← Back</button>
        <button id="nextBtn" type="button" onclick="showNext()">Next →</button>
      </div>
    </div>
  </div>

  <audio id="sound" preload="auto"></audio>

  <div class="page-arrows">
    <a class="arrow-btn" href="abc.php">← Back</a>
    <a class="arrow-btn" href="colors.php">Next →</a>
  </div>

  <div class="center-home-link">
    <a href="../index.php">Back to Home</a>
  </div>

</div>

<script>
const numbers = Array.from({ length: 20 }, (_, i) => i + 1);
let currentIndex = 0;

function showItem(num) {
  currentIndex = numbers.indexOf(num);
  updatePopup();
}

function updatePopup() {
  const num = numbers[currentIndex];

  document.getElementById("popupImg").src = `../assets/numbers/images/${num}.png`;
  document.getElementById("popupOverlay").style.display = "flex";

  document.getElementById("prevBtn").disabled = currentIndex === 0;
  document.getElementById("nextBtn").disabled = currentIndex === numbers.length - 1;

  playSound();
}

function playSound() {
  const num = numbers[currentIndex];
  const sound = document.getElementById("sound");

  sound.pause();
  sound.currentTime = 0;
  sound.src = `../assets/numbers/sounds/${num}.mp3?v=` + Date.now();
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
  if (currentIndex < numbers.length - 1) {
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
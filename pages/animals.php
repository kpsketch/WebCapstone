<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Animals - Kids Learning Hub</title>
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
          <div class='card' onclick=\"showItem('$a')\">
            <img src='../assets/animal-images/$a.png' alt='$a'>
            <div class='label'>".ucfirst($a)."</div>
          </div>
        ";
      }
    ?>
  </div>

  <div id="popupOverlay" class="popup-overlay" onclick="closePopup()">
    <div class="popup-box" onclick="replaySound(); event.stopPropagation()">
      <div id="popupLetter" class="popup-letter"></div>
      <img id="popupImg" src="" alt="Animal">
      <div id="popupText" class="popup-text"></div>

      <div class="popup-nav">
        <button id="prevBtn" type="button" onclick="showPrevious()">← Back</button>
        <button id="nextBtn" type="button" onclick="showNext()">Next →</button>
      </div>
    </div>
  </div>

  <audio id="sound" preload="auto"></audio>

  <div class="page-arrows">
    <a class="arrow-btn" href="shapes.php">← Back</a>
    <span class="arrow-btn disabled">Next →</span>
  </div>

  <div class="center-home-link">
    <a href="../index.php">Back to Home</a>
  </div>

</div>

<script>
const animals = [
  "alligator","bear","camel","cat","chicken","cow",
  "deer","dog","duck","elephant","fox","frog",
  "giraffe","hippo","horse","ladybug","lion","monkey",
  "mouse","owl","panda","peacock","penguin","pig",
  "sheep","snake","tiger","zebra"
];

let currentIndex = 0;
let audioReadyTimer = null;

function showItem(name) {
  currentIndex = animals.indexOf(name);
  updatePopup();
}

function updatePopup() {
  const name = animals[currentIndex];

  document.getElementById("popupImg").src = `../assets/animal-images/${name}.png`;
  document.getElementById("popupText").textContent = name.charAt(0).toUpperCase() + name.slice(1);
  document.getElementById("popupLetter").textContent = name.charAt(0).toUpperCase();
  document.getElementById("popupOverlay").style.display = "flex";

  document.getElementById("prevBtn").disabled = currentIndex === 0;
  document.getElementById("nextBtn").disabled = currentIndex === animals.length - 1;

  playSound();
}

function playSound() {
  const name = animals[currentIndex];
  const sound = document.getElementById("sound");

  if (audioReadyTimer) {
    clearTimeout(audioReadyTimer);
  }

  sound.pause();
  sound.currentTime = 0;

  sound.oncanplaythrough = null;
  sound.onloadeddata = null;

  sound.src = `../assets/animal-sounds/${name}.wav?v=` + Date.now();
  sound.load();

  sound.onloadeddata = function () {
    audioReadyTimer = setTimeout(function () {
      sound.currentTime = 0;
      sound.play().catch(() => {});
    }, 180);
  };
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
  if (currentIndex < animals.length - 1) {
    currentIndex++;
    updatePopup();
  }
}

function closePopup() {
  document.getElementById("popupOverlay").style.display = "none";

  if (audioReadyTimer) {
    clearTimeout(audioReadyTimer);
  }

  const sound = document.getElementById("sound");
  sound.pause();
  sound.currentTime = 0;
}
</script>

</body>
</html>
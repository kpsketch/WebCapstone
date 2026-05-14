<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Kids Learning Hub</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="site-header">
  <div class="header-inner">

    <div class="header-left">
      <div class="site-brand">
  <img src="assets/logo.png" class="site-logo" alt="Logo">
  
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
      <a href="index.php">Home</a>
      <a href="my_results.php">My Results</a>
      <a href="logout.php">Logout</a>
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

<div class="page-wrap">

  <main class="home-container">
    <div class="home-panel">

      <h2 class="home-heading">Choose a learning topic</h2>

      <div class="home-grid">
        <a href="pages/abc.php" class="home-card">
          <img src="assets/abc.png" alt="ABC">
          <span>ABC</span>
        </a>

        <a href="pages/numbers.php" class="home-card">
          <img src="assets/numbers.png" alt="Numbers">
          <span>Numbers</span>
        </a>

        <a href="pages/colors.php" class="home-card">
          <img src="assets/colors.png" alt="Colors">
          <span>Colors</span>
        </a>

        <a href="pages/shapes.php" class="home-card">
          <img src="assets/shapes.png" alt="Shapes">
          <span>Shapes</span>
        </a>

        <a href="pages/animals.php" class="home-card">
          <img src="assets/animals.png" alt="Animals">
          <span>Animals</span>
        </a>

        <a href="pages/quiz_menu.php" class="home-card">
          <img src="assets/quiz.png" alt="Quiz">
          <span>Quiz</span>
        </a>
      </div>

      <div class="info-strip">
        <div class="info-box">
          <h3>Why use this website?</h3>
          <p>Kids can learn using images, sounds and interactive quizzes.</p>
        </div>

        <div class="info-box">
          <h3>Track progress</h3>
          <p>Login to save quiz attempts and check results anytime.</p>
        </div>

        <div class="info-box">
          <h3>Easy to use</h3>
          <p>Simple navigation and clean design for better learning.</p>
        </div>
      </div>

    </div>
  </main>

  <footer class="site-footer">

  <div class="footer-inner">

    <div class="footer-brand">
      <img src="assets/logo.png" class="footer-logo" alt="Logo">
      <h3>Kids Learning Hub</h3>
      <p>Fun learning platform for kids to explore ABC, Numbers, Colors, Shapes and Animals.</p>
    </div>

    <div class="footer-links">
      <h4>Quick Links</h4>
      <a href="privacy.php">Privacy Policy</a>
      <a href="terms.php">Terms & Conditions</a>
      <a href="contact.php">Contact</a>
      <a href="support.php">Support</a>
    </div>

    <div class="footer-social">
      <h4>Follow Us</h4>
     <div class="footer-icons">
  <a href="#"><i class="fab fa-facebook-f"></i></a>
  <a href="#"><i class="fab fa-instagram"></i></a>
  <a href="#"><i class="fab fa-youtube"></i></a>
</div>
    </div>

  </div>

  <div class="footer-bottom">
    © 2026 Kids Learning Hub • Made for learning
  </div>

</footer>

</div>

</body>
</html>
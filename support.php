<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Support - Kids Learning Hub</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <div class="site-brand">
      <div class="site-title">Kids Learning Hub</div>
      <div class="site-tagline">Fun place to learn ABC, Numbers, Colors, Shapes and Animals</div>
    </div>

    <div class="header-right">
      <div class="social-icons">
        <a href="#" title="Facebook">FB</a>
        <a href="#" title="Instagram">IG</a>
        <a href="#" title="YouTube">YT</a>
      </div>

      <div class="topbar-links">
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <span class="topbar-user">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
          <a href="my_results.php">My Results</a>
          <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="login.php">Login</a>
          <a href="register.php">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>

<div class="page-wrap">
  <main class="home-container">
    <div class="home-panel">
      <h1 class="page-title">Support</h1>
      <p class="page-subtitle">Help for using the website and solving common issues.</p>

      <div class="info-strip">
        <div class="info-box">
          <h3>Login help</h3>
          <p>If you cannot log in, make sure your username or email and password are entered correctly.</p>
        </div>

        <div class="info-box">
          <h3>Quiz support</h3>
          <p>If quiz results are not showing, first complete or save the quiz attempt and then check My Results again.</p>
        </div>

        <div class="info-box">
          <h3>Technical issues</h3>
          <p>If audio, images, or pages do not load properly, refresh the page and check that the local server is running.</p>
        </div>
      </div>

      <div class="center-home-link">
        <a href="index.php">Back to Home</a>
      </div>
    </div>
  </main>

  <footer class="site-footer">
    <div class="footer-inner">
      <div class="footer-brand">
        <h3>Kids Learning Hub</h3>
        <p>Simple learning website for interactive practice and beginner education.</p>
      </div>

      <div class="footer-links">
        <a href="privacy.php">Privacy Policy</a>
        <a href="terms.php">Terms of Use</a>
        <a href="contact.php">Contact</a>
        <a href="support.php">Support</a>
      </div>

      <div class="footer-social">
        <a href="#">Facebook</a>
        <a href="#">Instagram</a>
        <a href="#">YouTube</a>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© 2026 Kids Learning Hub. All rights reserved.</p>
    </div>
  </footer>
</div>

</body>
</html>
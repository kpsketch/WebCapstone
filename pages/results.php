<?php
session_start();

$score = isset($_SESSION['quiz_score']) ? $_SESSION['quiz_score'] : 0;
$total = isset($_SESSION['quiz_questions']) ? count($_SESSION['quiz_questions']) : 0;
$category = isset($_SESSION['quiz_category']) ? $_SESSION['quiz_category'] : '';

if ($total === 0) {
    $total = 0;
}

$retryCategory = $category;

// clear session only after saving values
$_SESSION = [];
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Quiz Results - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .results-box{
      max-width: 750px;
      margin: 40px auto;
      background: #f4f7fb;
      border-radius: 22px;
      padding: 35px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.10);
      text-align: center;
    }

    .results-title{
      font-size: 34px;
      font-weight: 900;
      margin-bottom: 10px;
      color: #1e63c6;
    }

    .results-text{
      font-size: 20px;
      color: #555;
      margin-bottom: 20px;
    }

    .results-score{
      font-size: 46px;
      font-weight: 900;
      color: #1e63c6;
      margin: 20px 0 30px;
    }

    .results-links{
      display: flex;
      justify-content: center;
      gap: 18px;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    .results-btn{
      display: inline-block;
      padding: 14px 22px;
      background: #ffffff;
      border-radius: 14px;
      box-shadow: 0 6px 14px rgba(0,0,0,0.08);
      text-decoration: none;
      font-weight: 800;
      color: #1e63c6;
    }

    .results-btn:hover{
      background: #eaf3ff;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="page-panel">
  <div class="results-box">
    <div class="results-title">Quiz Completed</div>

    <div class="results-text">
      Great job finishing the <?php echo htmlspecialchars(ucfirst($retryCategory)); ?> quiz.
    </div>

    <div class="results-score">
      <?php echo $score; ?> / <?php echo $total; ?>
    </div>

    <div class="results-links">
      <a class="results-btn" href="quiz.php?category=<?php echo urlencode($retryCategory); ?>">Try Again</a>
      <a class="results-btn" href="quiz_menu.php">Back to Quiz</a>
      <a class="results-btn" href="../index.php">Back to Home</a>
    </div>
  </div>
</div>

</body>
</html>
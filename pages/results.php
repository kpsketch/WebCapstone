<?php
session_start();

if (
    !isset($_SESSION['quiz_score']) ||
    !isset($_SESSION['quiz_questions']) ||
    !isset($_SESSION['quiz_category'])
) {
    echo "Quiz session missing. Please go back and complete the quiz first.";
    exit();
}

$score = $_SESSION['quiz_score'];
$total = count($_SESSION['quiz_questions']);
$category = $_SESSION['quiz_category'];
$retryCategory = $category;

$saveMessage = isset($_SESSION['user_id'])
    ? "Your result has been saved."
    : "Login to save your results.";

/* clear only quiz session data, keep login session */
unset($_SESSION['quiz_score']);
unset($_SESSION['quiz_questions']);
unset($_SESSION['quiz_category']);
unset($_SESSION['quiz_index']);
unset($_SESSION['quiz_answered']);
unset($_SESSION['quiz_selected']);
unset($_SESSION['quiz_feedback']);
unset($_SESSION['quiz_speak']);
unset($_SESSION['quiz_is_correct']);
unset($_SESSION['quiz_saved']);
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
      margin: 20px 0 20px;
    }

    .save-note{
      font-size: 18px;
      font-weight: 800;
      margin-bottom: 20px;
      color: #2e7d32;
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

    <div class="save-note">
      <?php echo htmlspecialchars($saveMessage); ?>
    </div>

    <div class="results-links">
      <a class="results-btn" href="quiz.php?category=<?php echo urlencode($retryCategory); ?>">Try Again</a>
      <a class="results-btn" href="quiz_menu.php">Back to Quiz</a>
      <a class="results-btn" href="../index.php">Back to Home</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a class="results-btn" href="../my_results.php">My Results</a>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
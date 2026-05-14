<?php
session_start();
include("../database.php");

$allowed_categories = ['abc','numbers','colors','shapes','animals'];

if (isset($_GET['category'])) {
    $category = $_GET['category'];

    if (!in_array($category, $allowed_categories)) {
        die("Invalid quiz category.");
    }

    if (!isset($_SESSION['quiz_category']) || $_SESSION['quiz_category'] !== $category) {
        $_SESSION['quiz_category'] = $category;
        $_SESSION['quiz_score'] = 0;
        $_SESSION['quiz_index'] = 0;
        $_SESSION['quiz_answered'] = false;
        $_SESSION['quiz_selected'] = '';
        $_SESSION['quiz_feedback'] = '';
        $_SESSION['quiz_speak'] = '';
        $_SESSION['quiz_is_correct'] = false;
        $_SESSION['quiz_result_id'] = null;

        $stmt = $conn->prepare("SELECT * FROM quiz_questions WHERE category = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        $_SESSION['quiz_questions'] = [];

        while ($row = $result->fetch_assoc()) {
            $_SESSION['quiz_questions'][] = $row;
        }

        shuffle($_SESSION['quiz_questions']);

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $score = 0;
            $totalQuestions = count($_SESSION['quiz_questions']);
            $questionsAnswered = 0;
            $status = 'in_progress';

            $insertStmt = $conn->prepare("INSERT INTO quiz_results (user_id, category, score, total_questions, questions_answered, status) VALUES (?, ?, ?, ?, ?, ?)");
            if ($insertStmt) {
                $insertStmt->bind_param("isiiis", $userId, $category, $score, $totalQuestions, $questionsAnswered, $status);
                if ($insertStmt->execute()) {
                    $_SESSION['quiz_result_id'] = $conn->insert_id;
                }
                $insertStmt->close();
            }
        }
    }
} else {
    $category = $_SESSION['quiz_category'] ?? '';
}

if (empty($category) || !isset($_SESSION['quiz_questions'])) {
    die("No questions found under this category.");
}

$questions = $_SESSION['quiz_questions'];
$index = $_SESSION['quiz_index'];

if ($index >= count($questions)) {
    header("Location: results.php");
    exit();
}

$current = $questions[$index];

function getCorrectAnswerText($question) {
    $correct = strtoupper($question['correct_option']);

    switch ($correct) {
        case 'A': return $question['option_a'];
        case 'B': return $question['option_b'];
        case 'C': return $question['option_c'];
        case 'D': return $question['option_d'];
        default: return '';
    }
}

function buildSpeechText($category, $isCorrect, $question) {
    $answerText = getCorrectAnswerText($question);

    if (!$isCorrect) {
        return "That is wrong. Try again.";
    }

    return $answerText . ", that is correct.";
}

function updateQuizAttempt($conn, $questionsAnswered, $status) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['quiz_result_id']) || empty($_SESSION['quiz_result_id'])) {
        return;
    }

    $resultId = $_SESSION['quiz_result_id'];
    $score = $_SESSION['quiz_score'];
    $totalQuestions = count($_SESSION['quiz_questions']);

    $stmt = $conn->prepare("UPDATE quiz_results SET score = ?, total_questions = ?, questions_answered = ?, status = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("iiisi", $score, $totalQuestions, $questionsAnswered, $status, $resultId);
        $stmt->execute();
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['answer']) && $_SESSION['quiz_answered'] === false) {
        $selected = $_POST['answer'];
        $correct = $current['correct_option'];

        $_SESSION['quiz_selected'] = $selected;
        $_SESSION['quiz_answered'] = true;

        if ($selected === $correct) {
            $_SESSION['quiz_score']++;
            $_SESSION['quiz_feedback'] = "Correct!";
            $_SESSION['quiz_speak'] = buildSpeechText($category, true, $current);
            $_SESSION['quiz_is_correct'] = true;
        } else {
            $_SESSION['quiz_feedback'] = "Wrong! Try again or go to next question.";
            $_SESSION['quiz_speak'] = buildSpeechText($category, false, $current);
            $_SESSION['quiz_is_correct'] = false;
        }

        // save progress as soon as an answer is given
        $answeredCount = $_SESSION['quiz_index'] + 1;
        updateQuizAttempt($conn, $answeredCount, 'in_progress');
    }

    if (isset($_POST['try_again'])) {
        $_SESSION['quiz_answered'] = false;
        $_SESSION['quiz_selected'] = '';
        $_SESSION['quiz_feedback'] = '';
        $_SESSION['quiz_speak'] = '';
        $_SESSION['quiz_is_correct'] = false;
    }

    if (isset($_POST['next'])) {
        $nextIndex = $_SESSION['quiz_index'] + 1;
        $totalQuestions = count($_SESSION['quiz_questions']);

        if ($nextIndex >= $totalQuestions) {
            // final save before finish
            updateQuizAttempt($conn, $totalQuestions, 'completed');

            $_SESSION['quiz_index'] = $nextIndex;
            header("Location: results.php");
            exit();
        } else {
            $_SESSION['quiz_index'] = $nextIndex;

            // save normal progress
            updateQuizAttempt($conn, $nextIndex, 'in_progress');

            $_SESSION['quiz_answered'] = false;
            $_SESSION['quiz_selected'] = '';
            $_SESSION['quiz_feedback'] = '';
            $_SESSION['quiz_speak'] = '';
            $_SESSION['quiz_is_correct'] = false;

            $index = $_SESSION['quiz_index'];
            $current = $_SESSION['quiz_questions'][$index];
        }
    }
}

$answered = $_SESSION['quiz_answered'];
$selected = $_SESSION['quiz_selected'];
$feedback = $_SESSION['quiz_feedback'];
$speakText = $_SESSION['quiz_speak'];
$isCorrect = $_SESSION['quiz_is_correct'];

function getOptionClass($optionKey, $selected, $correct, $answered, $isCorrect) {
    if (!$answered) return "quiz-option-btn";

    if ($isCorrect) {
        if ($optionKey === $correct) {
            return "quiz-option-btn correct-option";
        }
        return "quiz-option-btn";
    }

    if ($optionKey === $selected) {
        return "quiz-option-btn wrong-option";
    }

    return "quiz-option-btn";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Quiz - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .quiz-box{
      max-width:900px;
      margin:30px auto;
      background:#f4f7fb;
      border-radius:22px;
      padding:30px;
      box-shadow:0 12px 30px rgba(0,0,0,0.10);
      text-align:center;
    }

    .quiz-top{
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:15px;
      flex-wrap:wrap;
      margin-bottom:18px;
      font-weight:800;
      color:#1f2d3d;
    }

    .quiz-image{
      width:220px;
      height:220px;
      object-fit:contain;
      margin:20px auto;
      display:block;
      background:#fff;
      border-radius:18px;
      padding:15px;
      box-shadow:0 8px 18px rgba(0,0,0,0.08);
    }

    .quiz-question{
      font-size:28px;
      font-weight:800;
      margin-bottom:20px;
    }

    .quiz-options{
      display:grid;
      grid-template-columns:repeat(2,1fr);
      gap:15px;
      margin-top:20px;
    }

    .quiz-option-btn{
      padding:16px;
      font-size:20px;
      font-weight:800;
      border:none;
      border-radius:14px;
      background:#ffffff;
      box-shadow:0 6px 14px rgba(0,0,0,0.08);
      cursor:pointer;
      transition:0.2s ease;
    }

    .quiz-option-btn:hover{
      background:#eaf3ff;
    }

    .quiz-option-btn:disabled{
      cursor:default;
      opacity:1;
    }

    .correct-option{
      background:#c8f7c5 !important;
      border:3px solid #2e9b37;
      color:#145a1f;
    }

    .wrong-option{
      background:#ffd1d1 !important;
      border:3px solid #d93b3b;
      color:#8a1f1f;
    }

    .feedback-box{
      margin:18px 0;
      padding:14px 20px;
      border-radius:12px;
      font-weight:800;
      font-size:20px;
      display:inline-block;
    }

    .feedback-correct{
      background:#dff7df;
      color:#1f6d2a;
      border:2px solid #2e9b37;
    }

    .feedback-wrong{
      background:#ffe0e0;
      color:#8b1e1e;
      border:2px solid #d93b3b;
    }

    .action-row{
      margin-top:25px;
      display:flex;
      justify-content:center;
      gap:14px;
      flex-wrap:wrap;
    }

    .action-btn{
      padding:14px 26px;
      font-size:20px;
      font-weight:800;
      border:none;
      border-radius:14px;
      cursor:pointer;
      box-shadow:0 6px 14px rgba(0,0,0,0.10);
    }

    .next-btn{
      background:#1e63c6;
      color:#fff;
    }

    .next-btn:hover{
      background:#174fa0;
    }

    .try-btn{
      background:#ffb84d;
      color:#4a2b00;
    }

    .try-btn:hover{
      background:#f0a634;
    }

    .quiz-nav{
      margin-top:30px;
      display:flex;
      justify-content:center;
      gap:20px;
      flex-wrap:wrap;
    }

    .nav-btn{
      background:#ffffff;
      padding:12px 20px;
      border-radius:12px;
      font-weight:800;
      text-decoration:none;
      color:#1e63c6;
      box-shadow:0 6px 14px rgba(0,0,0,0.08);
    }

    .nav-btn:hover{
      background:#eaf3ff;
      text-decoration:none;
    }

    @media (max-width:700px){
      .quiz-options{
        grid-template-columns:1fr;
      }

      .action-btn{
        width:100%;
      }
    }
  </style>
</head>
<body>

<div class="page-panel">
  <div class="quiz-box">

    <div class="quiz-top">
      <div>Category: <?php echo ucfirst($category); ?></div>
      <div>Score: <?php echo $_SESSION['quiz_score']; ?></div>
    </div>

    <div class="quiz-question">
      Question <?php echo $index + 1; ?> of <?php echo count($questions); ?>
    </div>

    <p class="page-subtitle">
      <?php echo htmlspecialchars($current['question_text']); ?>
    </p>

    <?php if (!empty($current['image_path'])): ?>
      <img class="quiz-image" src="<?php echo htmlspecialchars($current['image_path']); ?>" alt="Quiz Image">
    <?php endif; ?>

    <?php if (!empty($feedback)): ?>
      <div class="feedback-box <?php echo $isCorrect ? 'feedback-correct' : 'feedback-wrong'; ?>">
        <?php echo htmlspecialchars($feedback); ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="quiz-options">
        <button class="<?php echo getOptionClass('A', $selected, $current['correct_option'], $answered, $isCorrect); ?>" type="submit" name="answer" value="A" <?php echo $answered ? 'disabled' : ''; ?>>
          <?php echo htmlspecialchars($current['option_a']); ?>
        </button>

        <button class="<?php echo getOptionClass('B', $selected, $current['correct_option'], $answered, $isCorrect); ?>" type="submit" name="answer" value="B" <?php echo $answered ? 'disabled' : ''; ?>>
          <?php echo htmlspecialchars($current['option_b']); ?>
        </button>

        <button class="<?php echo getOptionClass('C', $selected, $current['correct_option'], $answered, $isCorrect); ?>" type="submit" name="answer" value="C" <?php echo $answered ? 'disabled' : ''; ?>>
          <?php echo htmlspecialchars($current['option_c']); ?>
        </button>

        <button class="<?php echo getOptionClass('D', $selected, $current['correct_option'], $answered, $isCorrect); ?>" type="submit" name="answer" value="D" <?php echo $answered ? 'disabled' : ''; ?>>
          <?php echo htmlspecialchars($current['option_d']); ?>
        </button>
      </div>

      <?php if ($answered): ?>
        <div class="action-row">
          <?php if (!$isCorrect): ?>
            <button class="action-btn try-btn" type="submit" name="try_again">Try Again</button>
          <?php endif; ?>

          <button class="action-btn next-btn" type="submit" name="next">
            <?php echo ($index + 1 >= count($questions)) ? 'Finish Quiz' : 'Next Question'; ?>
          </button>
        </div>
      <?php endif; ?>
    </form>

    <div class="quiz-nav">
      <a href="quiz_menu.php" class="nav-btn">← Back to Quiz</a>
      <a href="../index.php" class="nav-btn">🏠 Home</a>
    </div>

  </div>
</div>

<?php if (!empty($speakText)): ?>
<script>
window.addEventListener("load", function () {
  const text = <?php echo json_encode($speakText); ?>;

  if ("speechSynthesis" in window) {
    const speech = new SpeechSynthesisUtterance(text);

    speech.rate = 0.65;
    speech.pitch = 1;
    speech.volume = 1;

    setTimeout(() => {
      const voices = speechSynthesis.getVoices();
      const femaleVoice = voices.find(v => /female|samantha|zira|karen/i.test(v.name));

      if (femaleVoice) {
        speech.voice = femaleVoice;
      }

      speechSynthesis.cancel();
      speechSynthesis.speak(speech);
    }, 500);
  }
});
</script>
<?php endif; ?>

</body>
</html>
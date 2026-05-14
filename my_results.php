<?php
session_start();
include("database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT category, score, total_questions, questions_answered, status, played_at FROM quiz_results WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Results - WebCapstone</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .results-page{
      max-width:1000px;
      margin:35px auto;
      background:#f4f7fb;
      border-radius:22px;
      padding:30px;
      box-shadow:0 12px 30px rgba(0,0,0,0.10);
    }

    .results-page h1{
      text-align:center;
      margin-top:0;
      margin-bottom:10px;
    }

    .results-page p{
      text-align:center;
      color:#666;
      margin-bottom:25px;
    }

    table{
      width:100%;
      border-collapse:collapse;
      background:#fff;
      border-radius:14px;
      overflow:hidden;
    }

    th, td{
      padding:14px;
      border-bottom:1px solid #eee;
      text-align:center;
    }

    th{
      background:#1e63c6;
      color:#fff;
    }

    tr:last-child td{
      border-bottom:none;
    }

    .status-completed{
      color:#2e7d32;
      font-weight:800;
    }

    .status-progress{
      color:#d17b00;
      font-weight:800;
    }

    .no-results{
      text-align:center;
      background:#fff;
      padding:25px;
      border-radius:14px;
      font-weight:700;
      color:#555;
    }

    .bottom-links{
      text-align:center;
      margin-top:20px;
    }

    .bottom-links a{
      margin:0 10px;
      font-weight:800;
    }
  </style>
</head>
<body>

<div class="results-page">
  <h1>My Quiz Results</h1>
  <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>

  <?php if ($result->num_rows > 0): ?>
    <table>
      <tr>
        <th>Category</th>
        <th>Score</th>
        <th>Total Questions</th>
        <th>Answered</th>
        <th>Status</th>
        <th>Date</th>
      </tr>

      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars(ucfirst($row['category'])); ?></td>
          <td><?php echo htmlspecialchars($row['score']); ?></td>
          <td><?php echo htmlspecialchars($row['total_questions']); ?></td>
          <td><?php echo htmlspecialchars($row['questions_answered']); ?></td>
          <td class="<?php echo $row['status'] === 'completed' ? 'status-completed' : 'status-progress'; ?>">
            <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $row['status']))); ?>
          </td>
          <td><?php echo htmlspecialchars($row['played_at']); ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <div class="no-results">No quiz results found yet.</div>
  <?php endif; ?>

  <div class="bottom-links">
    <a href="index.php">← Back to Home</a>
    <a href="pages/quiz_menu.php">Take Quiz</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

</body>
</html>
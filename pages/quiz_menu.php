<!DOCTYPE html>
<html>
<head>
  <title>Quiz Menu - WebCapstone</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .quiz-menu-panel{
      max-width: 900px;
      margin: 30px auto;
      background: #f4f7fb;
      border-radius: 22px;
      padding: 30px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.10);
      text-align: center;
    }

    .quiz-menu-grid{
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-top: 25px;
    }

    .quiz-menu-card{
      display: block;
      background: #fff;
      padding: 25px;
      border-radius: 18px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      font-size: 22px;
      font-weight: 800;
      color: #1e63c6;
      text-decoration: none;
    }

    .quiz-menu-card:hover{
      transform: translateY(-3px);
      text-decoration: none;
    }

    @media (max-width: 700px){
      .quiz-menu-grid{
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<div class="page-panel">
  <h1 class="page-title">Choose a Quiz</h1>
  <p class="page-subtitle">Pick a category and test your learning.</p>

  <div class="quiz-menu-panel">
    <div class="quiz-menu-grid">
      <a class="quiz-menu-card" href="quiz.php?category=abc">ABC Quiz</a>
      <a class="quiz-menu-card" href="quiz.php?category=numbers">Numbers Quiz</a>
      <a class="quiz-menu-card" href="quiz.php?category=colors">Colors Quiz</a>
      <a class="quiz-menu-card" href="quiz.php?category=shapes">Shapes Quiz</a>
      <a class="quiz-menu-card" href="quiz.php?category=animals">Animals Quiz</a>
    </div>

    <p><a class="back-link" href="../index.php">← Back to Home</a></p>
  </div>
</div>

</body>
</html>
<?php
session_start();
include("database.php");

$message = "";

if (isset($_GET['registered'])) {
    $message = "Registration successful. Please login.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === "" || $password === "") {
        $message = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: index.php");
                exit();
            } else {
                $message = "Incorrect password.";
            }
        } else {
            $message = "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - WebCapstone</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .auth-page{
      max-width:500px;
      margin:40px auto;
      background:#f4f7fb;
      border-radius:22px;
      padding:30px;
      box-shadow:0 12px 30px rgba(0,0,0,0.10);
    }

    .auth-page h1{
      text-align:center;
      margin-top:0;
      margin-bottom:10px;
    }

    .auth-page p{
      text-align:center;
      color:#666;
      margin-bottom:25px;
    }

    .auth-form{
      display:flex;
      flex-direction:column;
      gap:15px;
    }

    .auth-form input{
      padding:14px;
      border:1px solid #ccc;
      border-radius:12px;
      font-size:16px;
    }

    .auth-form button{
      padding:14px;
      border:none;
      border-radius:12px;
      background:#1e63c6;
      color:#fff;
      font-size:18px;
      font-weight:800;
      cursor:pointer;
    }

    .auth-form button:hover{
      background:#174fa0;
    }

    .auth-message{
      text-align:center;
      margin-bottom:15px;
      color:#c62828;
      font-weight:700;
    }

    .auth-success{
      color:#2e7d32;
    }

    .auth-links{
      text-align:center;
      margin-top:18px;
    }

    .auth-links a{
      margin:0 8px;
    }
  </style>
</head>
<body>

<div class="auth-page">
  <h1>Login</h1>
  <p>Login to save your quiz results.</p>

  <?php if ($message !== ""): ?>
    <div class="auth-message <?php echo isset($_GET['registered']) ? 'auth-success' : ''; ?>">
      <?php echo htmlspecialchars($message); ?>
    </div>
  <?php endif; ?>

  <form method="post" class="auth-form">
    <input type="text" name="username" placeholder="Enter username or email" required>
    <input type="password" name="password" placeholder="Enter password" required>
    <button type="submit">Login</button>
  </form>

  <div class="auth-links">
    <a href="register.php">Create new account</a><br><br>
    <a href="index.php">← Back to Home</a>
  </div>
</div>

</body>
</html>
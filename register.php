<?php
session_start();
include("database.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($username === "" || $email === "" || $password === "") {
        $message = "Please fill in all fields.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Username or email already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register - WebCapstone</title>
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
  <h1>Create Account</h1>
  <p>Register to save quiz results and view them later.</p>

  <?php if ($message !== ""): ?>
    <div class="auth-message"><?php echo htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <form method="post" class="auth-form">
    <input type="text" name="username" placeholder="Enter username" required>
    <input type="email" name="email" placeholder="Enter email" required>
    <input type="password" name="password" placeholder="Enter password" required>
    <button type="submit">Register</button>
  </form>

  <div class="auth-links">
    <a href="login.php">Already have an account? Login</a><br><br>
    <a href="index.php">← Back to Home</a>
  </div>
</div>

</body>
</html>
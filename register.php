<?php
session_start();

if (isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit();
}

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "student_db";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Username or Email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Registration successful! You may now login.";
header("Location: login.php");
exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Balighot,Turaya,Defeo Student Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="light-mode">
  <div class="jdm-background">
    <div class="neon-lights"></div>
    <div class="city"></div>
    <div class="road"></div>
    <div class="car"></div>
  </div>

  <div class="toggle-container">
    <button id="modeToggle" class="btn btn-outline-jdm">🌙 Dark Mode</button>
  </div>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg login-card">
      <h2 class="text-center mb-4 jdm-font">REGISTER</h2>

      <?php if ($error_message): ?>
        <div class="alert alert-danger text-center animate__animated animate__shakeX">
          <?= htmlspecialchars($error_message) ?>
        </div>
      <?php endif; ?>

      <?php if ($success_message): ?>
        <div class="alert alert-success text-center animate__animated animate__fadeIn">
          <?= htmlspecialchars($success_message) ?>
        </div>
      <?php endif; ?>

      <form action="register.php" method="post">
        <div class="mb-3">
          <label for="username" class="form-label jdm-font">USERNAME</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label jdm-font">EMAIL</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label jdm-font">PASSWORD</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="confirm_password" class="form-label jdm-font">CONFIRM PASSWORD</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-jdm">REGISTER</button>
          <a href="login.php" class="btn btn-outline-jdm">BACK TO LOGIN</a>
        </div>
      </form>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
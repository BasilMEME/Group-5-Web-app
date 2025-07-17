<?php
session_start();
$conn = new mysqli("localhost", "root", "", "student_db");

$error = '';
$success_message = '';

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = isset($_POST['username_or_email']) ? trim($_POST['username_or_email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    }

    $stmt->bind_param("s", $input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'] ?? 'user';
            header("Location: view.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login | Balighot,Turaya,Defeo System</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="light-mode">
  <div class="jdm-background">
    <div class="neon-lights"></div>
    <div class="city"></div>
    <div class="road"></div>
    <div class="car"></div>
    <div class="car"></div> 
  </div>

  <div class="toggle-container">
    <button id="modeToggle" class="btn btn-outline-jdm">🌙 Dark Mode</button>
  </div>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4 animate__animated animate__fadeIn">
        <div class="login-card p-4">
          <div class="login-header text-center mb-4">
            <h2 class="jdm-font">🔒 LOGIN</h2>
            <p class="text-muted">Enter your credentials to access the system</p>
          </div>

          <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <?= htmlspecialchars($success_message) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <?= htmlspecialchars($error) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <form method="post">
            <div class="mb-3">
              <label for="username_or_email" class="form-label">Username or Email</label>
              <input type="text" name="username_or_email" class="form-control" placeholder="Enter your username or email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-jdm btn-lg">
                <span class="d-flex align-items-center justify-content-center">
                  <span class="me-2">LOGIN</span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                  </svg>
                </span>
              </button>
            </div>
          </form>

          <div class="text-center mt-3">
            Don't have an account? <a href="register.php" class="text-jdm-link">Register Here</a>
          </div>

          <div class="login-footer mt-4 text-center">
            <p class="text-muted small">Balighot, Turaya, Defeo Student Management System</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>

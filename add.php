<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "student_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $dob = $_POST['dob'];

    $stmt = $conn->prepare("INSERT INTO students (name, email, course, dob) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $course, $dob);
    $stmt->execute();
    header("Location: view.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Student | Balighot,Turaya,Defeo System</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="light-mode">
  <!-- Background Animation -->
  <div class="jdm-background">
    <div class="neon-lights"></div>
    <div class="city"></div>
    <div class="road"></div>
    <div class="car"></div>
  </div>

  <!-- Theme Toggle -->
  <div class="toggle-container">
    <button id="modeToggle" class="btn btn-outline-jdm">🌙 Dark Mode</button>
  </div>

  <div class="container mt-5">
    <h2 class="jdm-font text-center mb-4">➕ ADD NEW STUDENT</h2>
    
    <?php if (isset($error)): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    
    <form method="post" class="mx-auto" style="max-width: 500px;">
      <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="FULL NAME" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="EMAIL ADDRESS" required>
      </div>
      <div class="mb-3">
        <select name="course" class="form-select" required>
          <option value="" disabled selected>SELECT COURSE</option>
          <option value="" disabled>―――― COMPUTING ――――</option>
          <option value="BSIT">BS in Information Technology</option>
          <option value="BSCS">BS in Computer Science</option>
          <option value="BSIS">BS in Information System</option>
          <option value="BSCY">BS in Cybersecurity</option>
          <option value="BSDS">BS in Data Science</option>
          <option value="BSBT">BS in Blockchain Technology</option>
          <option value="BSAI">BS in Artificial Intelligence</option>
          <option value="BSEMC">BS in Entertainment & Multimedia Computing</option>
          <option value="" disabled>―― BUSINESS & MANAGEMENT ――</option>
          <option value="BSBA-MM">BSBA in Marketing Management</option>
          <option value="BSBA-HRM">BSBA in Human Resource Management</option>
          <option value="BSBA-MIS">BSBA in Management Info System</option>
          <option value="BSBA-FM">BSBA in Financial Management</option>
          <option value="BSE">BS in Entrepreneurship</option>
          <option value="BSREM">BS in Real Estate Management</option>
          <option value="" disabled>――― INDUSTRY SKILLS ―――</option>
          <option value="AMASS">AMASS Industry Certification</option>
        </select>
      </div>
      <div class="mb-4">
        <input type="date" name="dob" class="form-control" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-jdm btn-lg">ADD STUDENT</button>
      </div>
    </form>
    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-outline-jdm">← BACK TO HOME</a>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
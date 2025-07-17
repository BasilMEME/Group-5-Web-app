<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "student_db");
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $dob = $_POST['dob'];

    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, course=?, dob=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $course, $dob, $id);
    $stmt->execute();
    header("Location: view.php");
    exit();
}

$result = $conn->query("SELECT * FROM students WHERE id = $id");
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Student | Balighot,Turaya,Defeo System</title>
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
    <h2 class="jdm-font text-center mb-4">✏️ EDIT STUDENT</h2>
    <form method="post" class="mx-auto" style="max-width: 500px;">
      <div class="mb-3">
        <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <select name="course" class="form-select" required>
          <option value="" disabled selected>SELECT COURSE</option>
          <option value="" disabled>―――― COMPUTING ――――</option>
          <option value="BSIT" <?= $row['course'] == 'BSIT' ? 'selected' : '' ?>>BS in Information Technology</option>
          <option value="BSCS" <?= $row['course'] == 'BSCS' ? 'selected' : '' ?>>BS in Computer Science</option>
          <option value="BSIS" <?= $row['course'] == 'BSIS' ? 'selected' : '' ?>>BS in Information System</option>
          <option value="BSCY" <?= $row['course'] == 'BSCY' ? 'selected' : '' ?>>BS in Cybersecurity</option>
          <option value="BSDS" <?= $row['course'] == 'BSDS' ? 'selected' : '' ?>>BS in Data Science</option>
          <option value="BSBT" <?= $row['course'] == 'BSBT' ? 'selected' : '' ?>>BS in Blockchain Technology</option>
          <option value="BSAI" <?= $row['course'] == 'BSAI' ? 'selected' : '' ?>>BS in Artificial Intelligence</option>
          <option value="BSEMC" <?= $row['course'] == 'BSEMC' ? 'selected' : '' ?>>BS in Entertainment & Multimedia Computing</option>
          <option value="" disabled>―― BUSINESS & MANAGEMENT ――</option>
          <option value="BSBA-MM" <?= $row['course'] == 'BSBA-MM' ? 'selected' : '' ?>>BSBA in Marketing Management</option>
          <option value="BSBA-HRM" <?= $row['course'] == 'BSBA-HRM' ? 'selected' : '' ?>>BSBA in Human Resource Management</option>
          <option value="BSBA-MIS" <?= $row['course'] == 'BSBA-MIS' ? 'selected' : '' ?>>BSBA in Management Info System</option>
          <option value="BSBA-FM" <?= $row['course'] == 'BSBA-FM' ? 'selected' : '' ?>>BSBA in Financial Management</option>
          <option value="BSE" <?= $row['course'] == 'BSE' ? 'selected' : '' ?>>BS in Entrepreneurship</option>
          <option value="BSREM" <?= $row['course'] == 'BSREM' ? 'selected' : '' ?>>BS in Real Estate Management</option>
          <option value="" disabled>――― INDUSTRY SKILLS ―――</option>
          <option value="AMASS" <?= $row['course'] == 'AMASS' ? 'selected' : '' ?>>AMASS Industry Certification</option>
        </select>
      </div>
      <div class="mb-4">
        <input type="date" name="dob" value="<?= htmlspecialchars($row['dob']) ?>" class="form-control" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-jdm btn-lg">UPDATE STUDENT</button>
      </div>
    </form>
    <div class="text-center mt-4">
      <a href="view.php" class="btn btn-outline-jdm">← BACK TO LIST</a>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
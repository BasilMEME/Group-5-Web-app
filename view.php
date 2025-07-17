<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "student_db");
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$query = "SELECT * FROM students";
if (!empty($search)) {
    $query .= " WHERE name LIKE '%$search%' OR course LIKE '%$search%'";
}
$query .= " ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Students | Balighot,Turaya,Defeo System</title>
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

  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="jdm-font mb-0">📋 STUDENT RECORDS</h2>
      <div>
        <a href="logout.php" class="btn btn-outline-jdm me-2">LOGOUT</a>
        <a href="add.php" class="btn btn-jdm me-2">➕ ADD STUDENT</a>
        <a href="index.php" class="btn btn-jdm">🏠 HOME</a>
      </div>
    </div>

    <div class="search-container">
      <form method="get" class="row g-3">
        <div class="col-md-8">
          <input type="text" name="search" class="form-control search-input" placeholder="Search by name or course..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-jdm w-100">SEARCH</button>
        </div>
        <div class="col-md-2">
          <a href="view.php" class="btn btn-outline-jdm w-100">RESET</a>
        </div>
      </form>
    </div>
    
    <div class="student-records-section">
      <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>COURSE</th>
                <th>DOB</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['course']) ?></td>
                <td><?= htmlspecialchars($row['dob']) ?></td>
                <td>
                  <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-jdm">EDIT</a>
                  <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')" class="btn btn-sm btn-danger">DELETE</a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-jdm text-center">
          <h4 class="text-glow">NO STUDENTS FOUND</h4>
          <a href="add.php" class="btn btn-jdm mt-3">ADD FIRST STUDENT</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="recent-students animate__animated animate__fadeIn">
      <h3 class="jdm-font text-center mb-4">🌟 RECENTLY ADDED</h3>
      <div class="row">
        <?php
        $recent = $conn->query("SELECT * FROM students ORDER BY id DESC LIMIT 3");
        if ($recent->num_rows > 0):
          while($student = $recent->fetch_assoc()):
        ?>
        <div class="col-md-4 mb-4">
          <div class="student-card text-center">
            <div class="student-avatar mb-3">
              <?= strtoupper(substr($student['name'], 0, 1)) ?>
            </div>
            <h5><?= htmlspecialchars($student['name']) ?></h5>
            <p class="text-muted"><?= htmlspecialchars($student['course']) ?></p>
            <div class="student-info">
              <small><?= htmlspecialchars($student['email']) ?></small><br>
              <small>DOB: <?= htmlspecialchars($student['dob']) ?></small>
            </div>
          </div>
        </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
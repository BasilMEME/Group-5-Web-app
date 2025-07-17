<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "student_db");
$id = intval($_GET['id']);
$conn->query("DELETE FROM students WHERE id=$id");
header("Location: view.php");
exit();

<?php
require_once 'db.php';
$db = new Database();
$conn = $db->getConnection();

$grade_id = $_GET['id'];

// Get student_id before deletion for redirect
$grade = $conn->prepare("SELECT student_id FROM grades WHERE id = :id");
$grade->execute(['id' => $grade_id]);
$grade = $grade->fetch();

// Delete the grade
$stmt = $conn->prepare("DELETE FROM grades WHERE id = :id");
$stmt->execute(['id' => $grade_id]);

header("Location: grades.php?student_id=" . $grade['student_id']);
exit;
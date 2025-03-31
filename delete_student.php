<?php
require_once 'db.php';
$db = new Database();
$conn = $db->getConnection();

$album_number = $_GET['album_number'];

// Delete associated grades first due to foreign key constraints
$stmt = $conn->prepare("DELETE FROM grades WHERE student_id = :album_number");
$stmt->execute(['album_number' => $album_number]);

// Delete the student
$stmt = $conn->prepare("DELETE FROM students WHERE album_number = :album_number");
$stmt->execute(['album_number' => $album_number]);

header("Location: index.php");
exit;
<?php
require_once 'db.php';
$db = new Database();
$conn = $db->getConnection();

$album_number = $_GET['album_number'];
$student = $conn->prepare("SELECT * FROM students WHERE album_number = :album_number");
$student->execute(['album_number' => $album_number]);
$student = $student->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE students SET 
        first_name = :fname,
        last_name = :lname,
        current_semester = :semester 
        WHERE album_number = :album_number");
    $stmt->execute([
        'fname' => $_POST['first_name'],
        'lname' => $_POST['last_name'],
        'semester' => $_POST['current_semester'],
        'album_number' => $album_number
    ]);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Student</h1>
    <form method="POST">
        <label>Album Number: <?php echo $student['album_number']; ?></label><br>
        <label>First Name: 
            <input type="text" name="first_name" 
                   value="<?php echo $student['first_name']; ?>" required>
        </label><br>
        <label>Last Name: 
            <input type="text" name="last_name" 
                   value="<?php echo $student['last_name']; ?>" required>
        </label><br>
        <label>Semester: 
            <select name="current_semester">
                <?php for($i=1; $i<=7; $i++): ?>
                    <option value="<?php echo $i; ?>" 
                        <?php echo $student['current_semester'] == $i ? 'selected' : ''; ?>>
                        <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </label><br>
        <input type="submit" value="Update Student" class="button">
        <a href="index.php" class="button">Cancel</a>
    </form>
</body>
</html>
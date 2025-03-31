<?php
require_once 'db.php';
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, current_semester) 
        VALUES (:fname, :lname, :semester)");
    $stmt->execute([
        'fname' => $_POST['first_name'],
        'lname' => $_POST['last_name'],
        'semester' => $_POST['current_semester']
    ]);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add New Student</h1>
    <form method="POST">
        <label>First Name: <input type="text" name="first_name" required></label><br>
        <label>Last Name: <input type="text" name="last_name" required></label><br>
        <label>Semester: 
            <select name="current_semester">
                <?php for($i=1; $i<=7; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </label><br>
        <input type="submit" value="Add Student" class="button">
        <a href="index.php" class="button">Cancel</a>
    </form>
</body>
</html>
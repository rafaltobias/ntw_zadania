<?php
require_once 'db.php';
$db = new Database();
$conn = $db->getConnection();
?>

<!DOCTYPE html>
<html>
<head>
    <title>dziennik</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .button { padding: 5px 10px; margin: 2px; }
    </style>
</head>
<body>
    
    <h2>Students</h2>
    <a href="add_student.php" class="button">Add Student</a>
    
    <?php
    $stmt = $conn->prepare("SELECT * FROM students");
    $stmt->execute();
    $students = $stmt->fetchAll();
    ?>
    <table>
        <tr>
            <th>Album Nr</th>
            <th>Name</th>
            <th>Semester</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?php echo $student['album_number']; ?></td>
            <td><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></td>
            <td><?php echo $student['current_semester']; ?></td>
            <td>
                <a href="edit_student.php?album_number=<?php echo $student['album_number']; ?>" class="button">Edit</a>
                <a href="delete_student.php?album_number=<?php echo $student['album_number']; ?>" class="button">Delete</a>
                <a href="grades.php?student_id=<?php echo $student['album_number']; ?>" class="button">Grades</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
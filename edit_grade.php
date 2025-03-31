<?php
require_once 'db.php';
$db = new Database();
$conn = $db->getConnection();

$grade_id = $_GET['id'];
$grade = $conn->prepare("SELECT g.*, s.album_number AS student_id 
    FROM grades g 
    JOIN students s ON g.student_id = s.album_number 
    WHERE g.id = :id");
$grade->execute(['id' => $grade_id]);
$grade = $grade->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE grades SET 
        grade = :grade,
        entry_date = :date,
        teacher_id = :teacher_id 
        WHERE id = :id");
    $stmt->execute([
        'grade' => $_POST['grade'],
        'date' => $_POST['entry_date'],
        'teacher_id' => $_POST['teacher_id'],
        'id' => $grade_id
    ]);
    header("Location: grades.php?student_id=" . $grade['student_id']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Grade</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Grade</h1>
    <form method="POST">
        <label>Grade: 
            <select name="grade">
                <?php 
                $grades = [2.0, 3.0, 3.5, 4.0, 4.5, 5.0];
                foreach($grades as $g): ?>
                    <option value="<?php echo $g; ?>" 
                        <?php echo $grade['grade'] == $g ? 'selected' : ''; ?>>
                        <?php echo $g; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Date: 
            <input type="date" name="entry_date" 
                   value="<?php echo $grade['entry_date']; ?>" required>
        </label><br>
        <label>Teacher: 
            <select name="teacher_id">
                <?php
                $teachers = $conn->prepare("SELECT * FROM teachers");
                $teachers->execute();
                foreach ($teachers->fetchAll() as $teacher) {
                    $selected = $teacher['id'] == $grade['teacher_id'] ? 'selected' : '';
                    echo "<option value='{$teacher['id']}' $selected>{$teacher['first_name']} {$teacher['last_name']}</option>";
                }
                ?>
            </select>
        </label><br>
        <input type="submit" value="Update Grade" class="button">
        <a href="grades.php?student_id=<?php echo $grade['student_id']; ?>" 
           class="button">Cancel</a>
    </form>
</body>
</html>
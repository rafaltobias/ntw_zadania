<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';
$db = new Database();
$conn = $db->getConnection();

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

if (!$student_id) {
    die("Error: No student ID provided.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO grades (student_id, subject_id, grade, entry_date, teacher_id) 
        VALUES (:student_id, :subject_id, :grade, :date, :teacher_id)");
    $stmt->execute([
        'student_id' => $student_id,
        'subject_id' => $_POST['subject_id'],
        'grade' => $_POST['grade'],
        'date' => $_POST['entry_date'],
        'teacher_id' => $_POST['teacher_id']
    ]);
}

$student = $conn->prepare("SELECT * FROM students WHERE album_number = :album_number");
$student->execute(['album_number' => $student_id]);
$student = $student->fetch();

if (!$student) {
    die("Error: Student with album number $student_id not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grades - <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Grades for <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></h1>
    
    <h2>Add Grade</h2>
    <form method="POST">
        <label>Subject:
            <select name="subject_id">
                <?php
                $subjects = $conn->prepare("SELECT * FROM subjects WHERE semester_id = :semester");
                $subjects->execute(['semester' => $student['current_semester']]);
                foreach ($subjects->fetchAll() as $subject) {
                    echo "<option value='{$subject['id']}'>" . htmlspecialchars($subject['name']) . "</option>";
                }
                ?>
            </select>
        </label><br>
        <label>Grade: 
            <select name="grade">
                <option value="2.0">2.0</option>
                <option value="3.0">3.0</option>
                <option value="3.5">3.5</option>
                <option value="4.0">4.0</option>
                <option value="4.5">4.5</option>
                <option value="5.0">5.0</option>
            </select>
        </label><br>
        <label>Date: <input type="date" name="entry_date" required></label><br>
        <label>Teacher: 
            <select name="teacher_id">
                <?php
                $teachers = $conn->prepare("SELECT * FROM teachers");
                $teachers->execute();
                foreach ($teachers->fetchAll() as $teacher) {
                    echo "<option value='{$teacher['id']}'>" . htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']) . "</option>";
                }
                ?>
            </select>
        </label><br>
        <input type="submit" value="Add Grade" class="button">
    </form>

    <h2>Current Grades</h2>
    <?php
    $grades = $conn->prepare("SELECT g.*, s.name, t.first_name, t.last_name 
        FROM grades g 
        JOIN subjects s ON g.subject_id = s.id 
        JOIN teachers t ON g.teacher_id = t.id
        WHERE g.student_id = :student_id");
    $grades->execute(['student_id' => $student_id]);
    $grades_list = $grades->fetchAll();
    ?>
    <table>
        <tr>
            <th>Subject</th>
            <th>Grade</th>
            <th>Date</th>
            <th>Teacher</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($grades_list as $grade): ?>
        <tr>
            <td><?php echo htmlspecialchars($grade['name']); ?></td>
            <td><?php echo htmlspecialchars($grade['grade']); ?></td>
            <td><?php echo htmlspecialchars($grade['entry_date']); ?></td>
            <td><?php echo htmlspecialchars($grade['first_name'] . ' ' . $grade['last_name']); ?></td>
            <td>
                <a href="edit_grade.php?id=<?php echo $grade['id']; ?>" class="button">Edit</a>
                <a href="delete_grade.php?id=<?php echo $grade['id']; ?>" class="button">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php" class="button">Back to Students</a>
</body>
</html>
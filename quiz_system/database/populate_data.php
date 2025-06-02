<?php
// Database population script
// This script will populate the quiz_system database with sample data

require_once '../app/config/database.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connecting to database...\n";
    
    // Check if we already have data (skip default teacher)
    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE id > 1");
    $existing_users = $stmt->fetchColumn();
    
    if ($existing_users > 0) {
        echo "Database already contains sample data. Do you want to continue? (y/n): ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        if (trim($line) !== 'y') {
            echo "Aborting...\n";
            exit;
        }
        fclose($handle);
        
        // Clear existing data (except default teacher)
        echo "Clearing existing sample data...\n";
        $pdo->exec("DELETE FROM student_answers WHERE id > 0");
        $pdo->exec("DELETE FROM test_results WHERE id > 0");
        $pdo->exec("DELETE FROM test_assignments WHERE id > 0");
        $pdo->exec("DELETE FROM test_questions WHERE id > 0");
        $pdo->exec("DELETE FROM answers WHERE id > 0");
        $pdo->exec("DELETE FROM questions WHERE id > 0");
        $pdo->exec("DELETE FROM tests WHERE id > 0");
        $pdo->exec("DELETE FROM student_class WHERE id > 0");
        $pdo->exec("DELETE FROM classes WHERE id > 0");
        $pdo->exec("DELETE FROM users WHERE id > 1");
    }
    
    echo "Populating database with sample data...\n";
    
    // 1. Insert 5 additional teachers and 10 students (total 16 users including default teacher)
    echo "Adding users...\n";
    
    // Teachers
    $teachers_data = [
        ['teacher2', 'Maria Kowalska', 'maria.kowalska@school.edu'],
        ['teacher3', 'Jan Nowak', 'jan.nowak@school.edu'],
        ['teacher4', 'Anna Wiśniewska', 'anna.wisniewska@school.edu'],
        ['teacher5', 'Piotr Lewandowski', 'piotr.lewandowski@school.edu'],
        ['teacher6', 'Katarzyna Zielińska', 'katarzyna.zielinska@school.edu']
    ];
      $password = 'password';
    
    foreach ($teachers_data as $teacher) {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, name, role, email) VALUES (?, ?, ?, 'teacher', ?)");
        $stmt->execute([$teacher[0], $password, $teacher[1], $teacher[2]]);
    }
    
    // Students
    $students_data = [
        ['student1', 'Adam Kowalczyk', 'adam.kowalczyk@student.edu'],
        ['student2', 'Ewa Nowakowa', 'ewa.nowakowa@student.edu'],
        ['student3', 'Michał Wiśniewski', 'michal.wisniewski@student.edu'],
        ['student4', 'Agnieszka Lewandowska', 'agnieszka.lewandowska@student.edu'],
        ['student5', 'Tomasz Zieliński', 'tomasz.zielinski@student.edu'],
        ['student6', 'Magdalena Kamińska', 'magdalena.kaminska@student.edu'],
        ['student7', 'Łukasz Dąbrowski', 'lukasz.dabrowski@student.edu'],
        ['student8', 'Karolina Szymańska', 'karolina.szymanska@student.edu'],
        ['student9', 'Bartosz Kozłowski', 'bartosz.kozlowski@student.edu'],
        ['student10', 'Natalia Jankowska', 'natalia.jankowska@student.edu']
    ];
      foreach ($students_data as $student) {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, name, role, email) VALUES (?, ?, ?, 'student', ?)");
        $stmt->execute([$student[0], $password, $student[1], $student[2]]);
    }
    
    // 2. Insert 10 classes
    echo "Adding classes...\n";
    
    $classes_data = [
        ['Matematyka - Klasa 1A', 'Podstawy matematyki dla pierwszej klasy'],
        ['Historia - Klasa 2B', 'Historia Polski i świata'],
        ['Fizyka - Klasa 3C', 'Podstawy fizyki i mechaniki'],
        ['Chemia - Klasa 1B', 'Wprowadzenie do chemii'],
        ['Biologia - Klasa 2A', 'Biologia człowieka i przyrody'],
        ['Geografia - Klasa 3A', 'Geografia Polski i Europy'],
        ['Język Polski - Klasa 1C', 'Literatura i gramatyka'],
        ['Język Angielski - Klasa 2C', 'Konwersacje i gramatyka angielska'],
        ['Informatyka - Klasa 3B', 'Programowanie i algorytmy'],
        ['WOS - Klasa 1A', 'Wiedza o społeczeństwie']
    ];
    
    foreach ($classes_data as $class) {
        $stmt = $pdo->prepare("INSERT INTO classes (name, description) VALUES (?, ?)");
        $stmt->execute([$class[0], $class[1]]);
    }
    
    // 3. Assign students to classes (student_class table)
    echo "Assigning students to classes...\n";
    
    // Get student and class IDs
    $students = $pdo->query("SELECT id FROM users WHERE role = 'student'")->fetchAll(PDO::FETCH_COLUMN);
    $classes = $pdo->query("SELECT id FROM classes")->fetchAll(PDO::FETCH_COLUMN);
    
    // Assign each student to 2-3 random classes
    foreach ($students as $student_id) {
        $num_classes = rand(2, 3);
        $assigned_classes = array_rand(array_flip($classes), $num_classes);
        
        if (!is_array($assigned_classes)) {
            $assigned_classes = [$assigned_classes];
        }
        
        foreach ($assigned_classes as $class_id) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO student_class (user_id, class_id) VALUES (?, ?)");
            $stmt->execute([$student_id, $class_id]);
        }
    }
    
    // 4. Insert questions for each teacher
    echo "Adding questions...\n";
    
    $teachers = $pdo->query("SELECT id FROM users WHERE role = 'teacher'")->fetchAll(PDO::FETCH_COLUMN);
    
    $sample_questions = [
        ['Która z poniższych liczb jest liczbą pierwszą?', 'matematyka'],
        ['Kto był pierwszym królem Polski?', 'historia'],
        ['Jaka jest prędkość światła w próżni?', 'fizyka'],
        ['Który pierwiastek ma symbol chemiczny O?', 'chemia'],
        ['Ile chromosomów ma człowiek?', 'biologia'],
        ['Która rzeka przepływa przez Warszawę?', 'geografia'],
        ['Kto napisał "Lalka"?', 'polski'],
        ['Jak brzmi Present Perfect w języku angielskim?', 'angielski'],
        ['Co to jest algorytm?', 'informatyka'],
        ['Kiedy przyjęto Konstytucję 3 Maja?', 'wos']
    ];
    
    $all_questions = [];
    foreach ($teachers as $teacher_id) {
        for ($i = 0; $i < 10; $i++) {
            $question = $sample_questions[$i % count($sample_questions)];
            $content = $question[0] . " (Nauczyciel ID: $teacher_id, Pytanie " . ($i + 1) . ")";
            
            $stmt = $pdo->prepare("INSERT INTO questions (content, created_by) VALUES (?, ?)");
            $stmt->execute([$content, $teacher_id]);
            $question_id = $pdo->lastInsertId();
            $all_questions[] = $question_id;
        }
    }
    
    // 5. Add answers for each question (4 answers per question, 1 correct)
    echo "Adding answers...\n";
    
    $sample_answers = [
        ['A) 15', 'B) 17', 'C) 18', 'D) 20'], // math - 17 is correct
        ['A) Bolesław Chrobry', 'B) Mieszko I', 'C) Kazimierz Wielki', 'D) Władysław Jagiełło'], // history - Bolesław Chrobry
        ['A) 300,000 km/s', 'B) 299,792,458 m/s', 'C) 150,000 km/s', 'D) 1,000,000 m/s'], // physics - 299,792,458 m/s
        ['A) Wodór', 'B) Tlen', 'C) Azot', 'D) Węgiel'], // chemistry - Tlen
        ['A) 44', 'B) 46', 'C) 48', 'D) 50'], // biology - 46
        ['A) Wisła', 'B) Odra', 'C) Bug', 'D) San'], // geography - Wisła
        ['A) Henryk Sienkiewicz', 'B) Bolesław Prus', 'C) Adam Mickiewicz', 'D) Juliusz Słowacki'], // polish - Bolesław Prus
        ['A) have + V3', 'B) had + V3', 'C) will + V1', 'D) am/is/are + Ving'], // english - have + V3
        ['A) Program komputerowy', 'B) Język programowania', 'C) Zestaw instrukcji', 'D) Baza danych'], // IT - Zestaw instrukcji
        ['A) 1791', 'B) 1795', 'C) 1807', 'D) 1815'] // WOS - 1791
    ];
    
    $correct_answers = [1, 0, 1, 1, 1, 0, 1, 0, 2, 0]; // indices of correct answers
    
    foreach ($all_questions as $index => $question_id) {
        $answer_set = $sample_answers[$index % count($sample_answers)];
        $correct_index = $correct_answers[$index % count($correct_answers)];
        
        for ($i = 0; $i < 4; $i++) {
            $is_correct = ($i == $correct_index) ? 1 : 0;
            $stmt = $pdo->prepare("INSERT INTO answers (question_id, content, is_correct) VALUES (?, ?, ?)");
            $stmt->execute([$question_id, $answer_set[$i], $is_correct]);
        }
    }
    
    // 6. Create tests
    echo "Creating tests...\n";
    
    $test_titles = [
        'Test z Matematyki - Liczby pierwsze',
        'Test z Historii - Królowie Polski',
        'Test z Fizyki - Prędkość światła',
        'Test z Chemii - Pierwiastki',
        'Test z Biologii - Genetyka',
        'Test z Geografii - Rzeki Polski',
        'Test z Języka Polskiego - Literatura',
        'Test z Języka Angielskiego - Gramatyka',
        'Test z Informatyki - Algorytmy',
        'Test z WOS - Historia konstytucji'
    ];
    
    $all_tests = [];
    foreach ($teachers as $teacher_id) {
        for ($i = 0; $i < 2; $i++) { // 2 tests per teacher (12 total)
            $title = $test_titles[($teacher_id - 1) * 2 + $i] ?? "Test $teacher_id-$i";
            $description = "Opis testu: $title";
            
            $stmt = $pdo->prepare("INSERT INTO tests (title, description, created_by) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $teacher_id]);
            $test_id = $pdo->lastInsertId();
            $all_tests[] = $test_id;
        }
    }
    
    // 7. Assign questions to tests
    echo "Assigning questions to tests...\n";
    
    // Get questions by teacher
    foreach ($teachers as $teacher_id) {
        $teacher_questions = $pdo->prepare("SELECT id FROM questions WHERE created_by = ? LIMIT 10");
        $teacher_questions->execute([$teacher_id]);
        $questions = $teacher_questions->fetchAll(PDO::FETCH_COLUMN);
        
        $teacher_tests = $pdo->prepare("SELECT id FROM tests WHERE created_by = ?");
        $teacher_tests->execute([$teacher_id]);
        $tests = $teacher_tests->fetchAll(PDO::FETCH_COLUMN);
        
        foreach ($tests as $test_id) {
            // Assign 5 random questions to each test
            $selected_questions = array_rand(array_flip($questions), min(5, count($questions)));
            if (!is_array($selected_questions)) {
                $selected_questions = [$selected_questions];
            }
            
            foreach ($selected_questions as $question_id) {
                $stmt = $pdo->prepare("INSERT IGNORE INTO test_questions (test_id, question_id) VALUES (?, ?)");
                $stmt->execute([$test_id, $question_id]);
            }
        }
    }
    
    // 8. Assign tests to classes and students
    echo "Assigning tests to classes...\n";
    
    foreach ($all_tests as $test_id) {
        // Assign to 1-2 random classes
        $num_classes = rand(1, 2);
        $assigned_classes = array_rand(array_flip($classes), $num_classes);
        
        if (!is_array($assigned_classes)) {
            $assigned_classes = [$assigned_classes];
        }
        
        foreach ($assigned_classes as $class_id) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO test_assignments (test_id, class_id) VALUES (?, ?)");
            $stmt->execute([$test_id, $class_id]);
        }
    }
    
    // 9. Generate test results (some students completed some tests)
    echo "Generating test results...\n";
    
    // Get assigned tests for students through classes
    $stmt = $pdo->query("
        SELECT DISTINCT ta.test_id, sc.user_id as student_id
        FROM test_assignments ta
        JOIN student_class sc ON ta.class_id = sc.class_id
        WHERE ta.class_id IS NOT NULL
    ");
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 30% of assigned tests will be completed
    $completed_assignments = array_rand($assignments, min(30, round(count($assignments) * 0.3)));
    if (!is_array($completed_assignments)) {
        $completed_assignments = [$completed_assignments];
    }
    
    foreach ($completed_assignments as $index) {
        $assignment = $assignments[$index];
        $test_id = $assignment['test_id'];
        $student_id = $assignment['student_id'];
        
        // Get number of questions in test
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM test_questions WHERE test_id = ?");
        $stmt->execute([$test_id]);
        $total_questions = $stmt->fetchColumn();
        
        if ($total_questions > 0) {
            // Generate random score (40-100% success rate)
            $success_rate = rand(40, 100) / 100;
            $score = round($total_questions * $success_rate);
            
            // Insert test result
            $stmt = $pdo->prepare("INSERT INTO test_results (user_id, test_id, score, completed_at) VALUES (?, ?, ?, NOW() - INTERVAL ? DAY)");
            $days_ago = rand(1, 30);
            $stmt->execute([$student_id, $test_id, $score, $days_ago]);
            $result_id = $pdo->lastInsertId();
            
            // Generate student answers
            $stmt = $pdo->prepare("
                SELECT q.id as question_id, 
                       (SELECT a.id FROM answers a WHERE a.question_id = q.id AND a.is_correct = 1 LIMIT 1) as correct_answer_id,
                       (SELECT GROUP_CONCAT(a.id) FROM answers a WHERE a.question_id = q.id) as all_answer_ids
                FROM questions q 
                JOIN test_questions tq ON q.id = tq.question_id 
                WHERE tq.test_id = ?
            ");
            $stmt->execute([$test_id]);
            $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $correct_answers = 0;
            foreach ($questions as $question) {
                $all_answers = explode(',', $question['all_answer_ids']);
                
                // Decide if student got this question right based on overall score
                $got_it_right = (rand(1, 100) <= ($success_rate * 100));
                
                if ($got_it_right && $correct_answers < $score) {
                    $selected_answer = $question['correct_answer_id'];
                    $correct_answers++;
                } else {
                    // Pick a wrong answer
                    $wrong_answers = array_filter($all_answers, function($id) use ($question) {
                        return $id != $question['correct_answer_id'];
                    });
                    $selected_answer = $wrong_answers[array_rand($wrong_answers)];
                }
                
                $stmt = $pdo->prepare("INSERT INTO student_answers (result_id, question_id, answer_id) VALUES (?, ?, ?)");
                $stmt->execute([$result_id, $question['question_id'], $selected_answer]);
            }
        }
    }
    
    echo "\n✅ Database populated successfully!\n\n";
    echo "Summary:\n";
    echo "- Users: " . $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() . " (6 teachers, 10 students)\n";
    echo "- Classes: " . $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn() . "\n";
    echo "- Questions: " . $pdo->query("SELECT COUNT(*) FROM questions")->fetchColumn() . "\n";
    echo "- Answers: " . $pdo->query("SELECT COUNT(*) FROM answers")->fetchColumn() . "\n";
    echo "- Tests: " . $pdo->query("SELECT COUNT(*) FROM tests")->fetchColumn() . "\n";
    echo "- Test Results: " . $pdo->query("SELECT COUNT(*) FROM test_results")->fetchColumn() . "\n";
    echo "- Student-Class Assignments: " . $pdo->query("SELECT COUNT(*) FROM student_class")->fetchColumn() . "\n";
    echo "- Test Assignments: " . $pdo->query("SELECT COUNT(*) FROM test_assignments")->fetchColumn() . "\n";
    echo "- Student Answers: " . $pdo->query("SELECT COUNT(*) FROM student_answers")->fetchColumn() . "\n";
    
    echo "\nLogin credentials:\n";
    echo "Teachers: teacher, teacher2, teacher3, teacher4, teacher5, teacher6\n";
    echo "Students: student1, student2, student3, student4, student5, student6, student7, student8, student9, student10\n";
    echo "Password for all accounts: password\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>

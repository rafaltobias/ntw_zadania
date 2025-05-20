<?php
class Test {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Create a new test
    public function createTest($data) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Insert test
            $this->db->query('INSERT INTO tests (title, description, created_by) VALUES (:title, :description, :created_by)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':created_by', $data['created_by']);
            $this->db->execute();
            
            // Get the ID of the inserted test
            $test_id = $this->db->lastInsertId();
            
            // If questions are provided, add them to the test
            if(!empty($data['questions'])) {
                foreach($data['questions'] as $question_id) {
                    $this->db->query('INSERT INTO test_questions (test_id, question_id) VALUES (:test_id, :question_id)');
                    $this->db->bind(':test_id', $test_id);
                    $this->db->bind(':question_id', $question_id);
                    $this->db->execute();
                }
            }
            
            // Commit transaction
            $this->db->query('COMMIT');
            $this->db->execute();
            
            return $test_id;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            return false;
        }
    }
    
    // Get test by ID with questions
    public function getTestById($id) {
        $this->db->query('SELECT * FROM tests WHERE id = :id');
        $this->db->bind(':id', $id);
        
        $test = $this->db->single();
        
        if($test) {
            // Get questions for this test
            $this->db->query('SELECT q.* FROM questions q 
                            JOIN test_questions tq ON q.id = tq.question_id 
                            WHERE tq.test_id = :test_id');
            $this->db->bind(':test_id', $id);
            $test->questions = $this->db->resultSet();
            
            // Get number of questions
            $test->question_count = count($test->questions);
        }
        
        return $test;
    }
    
    // Get all tests by teacher ID
    public function getTestsByTeacher($teacher_id) {
        $this->db->query('SELECT * FROM tests WHERE created_by = :teacher_id ORDER BY created_at DESC');
        $this->db->bind(':teacher_id', $teacher_id);
        
        $tests = $this->db->resultSet();
        
        // Get question count for each test
        foreach($tests as $test) {
            $this->db->query('SELECT COUNT(*) as count FROM test_questions WHERE test_id = :test_id');
            $this->db->bind(':test_id', $test->id);
            $count = $this->db->single();
            $test->question_count = $count->count;
        }
        
        return $tests;
    }
    
    // Update test
    public function updateTest($data) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Update test
            $this->db->query('UPDATE tests SET title = :title, description = :description WHERE id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':id', $data['id']);
            $this->db->execute();
            
            // If questions are provided, update them
            if(isset($data['questions'])) {
                // Delete existing questions
                $this->db->query('DELETE FROM test_questions WHERE test_id = :test_id');
                $this->db->bind(':test_id', $data['id']);
                $this->db->execute();
                
                // Add new questions
                foreach($data['questions'] as $question_id) {
                    $this->db->query('INSERT INTO test_questions (test_id, question_id) VALUES (:test_id, :question_id)');
                    $this->db->bind(':test_id', $data['id']);
                    $this->db->bind(':question_id', $question_id);
                    $this->db->execute();
                }
            }
            
            // Commit transaction
            $this->db->query('COMMIT');
            $this->db->execute();
            
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            return false;
        }
    }
    
    // Delete test
    public function deleteTest($id) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Delete test questions
            $this->db->query('DELETE FROM test_questions WHERE test_id = :test_id');
            $this->db->bind(':test_id', $id);
            $this->db->execute();
            
            // Delete test assignments
            $this->db->query('DELETE FROM test_assignments WHERE test_id = :test_id');
            $this->db->bind(':test_id', $id);
            $this->db->execute();
            
            // Delete test results
            $this->db->query('DELETE FROM test_results WHERE test_id = :test_id');
            $this->db->bind(':test_id', $id);
            $this->db->execute();
            
            // Delete test
            $this->db->query('DELETE FROM tests WHERE id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
            
            // Commit transaction
            $this->db->query('COMMIT');
            $this->db->execute();
            
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            return false;
        }
    }
    
    // Assign test to a student
    public function assignTestToStudent($test_id, $student_id) {
        $this->db->query('INSERT INTO test_assignments (test_id, user_id) VALUES (:test_id, :user_id)');
        $this->db->bind(':test_id', $test_id);
        $this->db->bind(':user_id', $student_id);
        
        return $this->db->execute();
    }
    
    // Assign test to a class
    public function assignTestToClass($test_id, $class_id) {
        $this->db->query('INSERT INTO test_assignments (test_id, class_id) VALUES (:test_id, :class_id)');
        $this->db->bind(':test_id', $test_id);
        $this->db->bind(':class_id', $class_id);
        
        return $this->db->execute();
    }
    
    // Get tests assigned to a student
    public function getTestsAssignedToStudent($student_id) {
        $this->db->query('SELECT DISTINCT t.* FROM tests t
                        JOIN test_assignments ta ON t.id = ta.test_id
                        LEFT JOIN classes c ON ta.class_id = c.id
                        LEFT JOIN student_class sc ON c.id = sc.class_id
                        WHERE (ta.user_id = :user_id OR sc.user_id = :user_id2)
                        AND t.id NOT IN (
                            SELECT tr.test_id FROM test_results tr WHERE tr.user_id = :user_id3
                        )
                        ORDER BY t.created_at DESC');
        $this->db->bind(':user_id', $student_id);
        $this->db->bind(':user_id2', $student_id);
        $this->db->bind(':user_id3', $student_id);
        
        return $this->db->resultSet();
    }
    
    // Get completed tests by a student
    public function getCompletedTestsByStudent($student_id) {
        $this->db->query('SELECT t.*, tr.score, tr.completed_at FROM tests t 
                        JOIN test_results tr ON t.id = tr.test_id 
                        WHERE tr.user_id = :user_id
                        ORDER BY tr.completed_at DESC');
        $this->db->bind(':user_id', $student_id);
        
        return $this->db->resultSet();
    }
    
    // Submit test result
    public function submitTestResult($data) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Insert test result
            $this->db->query('INSERT INTO test_results (user_id, test_id, score) VALUES (:user_id, :test_id, :score)');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':test_id', $data['test_id']);
            $this->db->bind(':score', $data['score']);
            $this->db->execute();
            
            // Get the ID of the inserted result
            $result_id = $this->db->lastInsertId();
            
            // Insert student answers
            foreach($data['answers'] as $question_id => $answer_id) {
                $this->db->query('INSERT INTO student_answers (result_id, question_id, answer_id) 
                                VALUES (:result_id, :question_id, :answer_id)');
                $this->db->bind(':result_id', $result_id);
                $this->db->bind(':question_id', $question_id);
                $this->db->bind(':answer_id', $answer_id);
                $this->db->execute();
            }
            
            // Commit transaction
            $this->db->query('COMMIT');
            $this->db->execute();
            
            return $result_id;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            return false;
        }
    }
}
?>

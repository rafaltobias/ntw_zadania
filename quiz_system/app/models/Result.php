<?php
class Result {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get result by ID with detailed information
    public function getResultById($id) {
        $this->db->query('SELECT tr.*, t.title as test_title, u.name as student_name 
                        FROM test_results tr 
                        JOIN tests t ON tr.test_id = t.id 
                        JOIN users u ON tr.user_id = u.id 
                        WHERE tr.id = :id');
        $this->db->bind(':id', $id);
        
        $result = $this->db->single();
        
        if($result) {
            // Get test questions
            $this->db->query('SELECT q.*, a.id as student_answer_id 
                            FROM questions q
                            JOIN test_questions tq ON q.id = tq.question_id
                            LEFT JOIN student_answers sa ON q.id = sa.question_id AND sa.result_id = :result_id
                            LEFT JOIN answers a ON sa.answer_id = a.id
                            WHERE tq.test_id = :test_id');
            $this->db->bind(':result_id', $id);
            $this->db->bind(':test_id', $result->test_id);
            $questions = $this->db->resultSet();
            
            // Get all answers for each question
            foreach($questions as $question) {
                $this->db->query('SELECT * FROM answers WHERE question_id = :question_id');
                $this->db->bind(':question_id', $question->id);
                $question->answers = $this->db->resultSet();
                
                // Mark correct answer
                foreach($question->answers as $answer) {
                    if($answer->is_correct) {
                        $question->correct_answer_id = $answer->id;
                    }
                    if($answer->id == $question->student_answer_id) {
                        $question->is_correct = $answer->is_correct;
                    }
                }
            }
            
            $result->questions = $questions;
            $result->total_questions = count($questions);
        }
        
        return $result;
    }
    
    // Get all results for a teacher
    public function getResultsByTeacher($teacher_id) {
        $this->db->query('SELECT tr.*, t.title as test_title, u.name as student_name 
                        FROM test_results tr 
                        JOIN tests t ON tr.test_id = t.id 
                        JOIN users u ON tr.user_id = u.id 
                        WHERE t.created_by = :teacher_id
                        ORDER BY tr.completed_at DESC');
        $this->db->bind(':teacher_id', $teacher_id);
        
        return $this->db->resultSet();
    }
    
    // Get results by test ID
    public function getResultsByTest($test_id) {
        $this->db->query('SELECT tr.*, u.name as student_name 
                        FROM test_results tr 
                        JOIN users u ON tr.user_id = u.id 
                        WHERE tr.test_id = :test_id
                        ORDER BY tr.completed_at DESC');
        $this->db->bind(':test_id', $test_id);
        
        return $this->db->resultSet();
    }
    
    // Get results by student ID
    public function getResultsByStudent($student_id) {
        $this->db->query('SELECT tr.*, t.title as test_title 
                        FROM test_results tr 
                        JOIN tests t ON tr.test_id = t.id 
                        WHERE tr.user_id = :student_id
                        ORDER BY tr.completed_at DESC');
        $this->db->bind(':student_id', $student_id);
        
        return $this->db->resultSet();
    }
    
    // Get average score for a test
    public function getAverageScoreForTest($test_id) {
        $this->db->query('SELECT AVG(score) as average_score FROM test_results WHERE test_id = :test_id');
        $this->db->bind(':test_id', $test_id);
        
        $result = $this->db->single();
        
        return $result->average_score;
    }
    
    // Get student answers for a test
    public function getStudentAnswers($result_id) {
        $this->db->query('SELECT sa.*, a.content as answer_content, a.is_correct, q.content as question_content 
                        FROM student_answers sa 
                        JOIN answers a ON sa.answer_id = a.id 
                        JOIN questions q ON sa.question_id = q.id 
                        WHERE sa.result_id = :result_id');
        $this->db->bind(':result_id', $result_id);
        
        return $this->db->resultSet();
    }
    
    // Delete a result
    public function deleteResult($id) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Delete student answers
            $this->db->query('DELETE FROM student_answers WHERE result_id = :result_id');
            $this->db->bind(':result_id', $id);
            $this->db->execute();
            
            // Delete result
            $this->db->query('DELETE FROM test_results WHERE id = :id');
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
}
?>

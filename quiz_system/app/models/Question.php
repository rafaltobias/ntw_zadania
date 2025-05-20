<?php
class Question {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Add new question with answers
    public function addQuestion($data) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Insert question
            $this->db->query('INSERT INTO questions (content, created_by) VALUES (:content, :created_by)');
            $this->db->bind(':content', $data['content']);
            $this->db->bind(':created_by', $data['created_by']);
            $this->db->execute();
            
            // Get the ID of the inserted question
            $question_id = $this->db->lastInsertId();
            
            // Insert answers
            foreach($data['answers'] as $index => $answer) {
                $is_correct = ($index == $data['correct_answer']) ? 1 : 0;
                
                $this->db->query('INSERT INTO answers (question_id, content, is_correct) VALUES (:question_id, :content, :is_correct)');
                $this->db->bind(':question_id', $question_id);
                $this->db->bind(':content', $answer);
                $this->db->bind(':is_correct', $is_correct);
                $this->db->execute();
            }
            
            // Commit transaction
            $this->db->query('COMMIT');
            $this->db->execute();
            
            return $question_id;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            return false;
        }
    }
    
    // Get question by ID with answers
    public function getQuestionById($id) {
        $this->db->query('SELECT * FROM questions WHERE id = :id');
        $this->db->bind(':id', $id);
        
        $question = $this->db->single();
        
        if($question) {
            $this->db->query('SELECT * FROM answers WHERE question_id = :question_id');
            $this->db->bind(':question_id', $id);
            
            $question->answers = $this->db->resultSet();
        }
        
        return $question;
    }
    
    // Get all questions by teacher ID
    public function getQuestionsByTeacher($teacher_id) {
        $this->db->query('SELECT * FROM questions WHERE created_by = :teacher_id ORDER BY created_at DESC');
        $this->db->bind(':teacher_id', $teacher_id);
        
        return $this->db->resultSet();
    }
    
    // Update question with answers
    public function updateQuestion($data) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Update question
            $this->db->query('UPDATE questions SET content = :content WHERE id = :id');
            $this->db->bind(':content', $data['content']);
            $this->db->bind(':id', $data['id']);
            $this->db->execute();
            
            // Delete existing answers
            $this->db->query('DELETE FROM answers WHERE question_id = :question_id');
            $this->db->bind(':question_id', $data['id']);
            $this->db->execute();
            
            // Insert new answers
            foreach($data['answers'] as $index => $answer) {
                $is_correct = ($index == $data['correct_answer']) ? 1 : 0;
                
                $this->db->query('INSERT INTO answers (question_id, content, is_correct) VALUES (:question_id, :content, :is_correct)');
                $this->db->bind(':question_id', $data['id']);
                $this->db->bind(':content', $answer);
                $this->db->bind(':is_correct', $is_correct);
                $this->db->execute();
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
    
    // Delete question and its answers
    public function deleteQuestion($id) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Delete answers
            $this->db->query('DELETE FROM answers WHERE question_id = :question_id');
            $this->db->bind(':question_id', $id);
            $this->db->execute();
            
            // Delete question
            $this->db->query('DELETE FROM questions WHERE id = :id');
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
    
    // Get correct answer for a question
    public function getCorrectAnswer($question_id) {
        $this->db->query('SELECT * FROM answers WHERE question_id = :question_id AND is_correct = 1');
        $this->db->bind(':question_id', $question_id);
        
        return $this->db->single();
    }
    
    // Get questions not in a specific test
    public function getQuestionsNotInTest($test_id, $teacher_id) {
        $this->db->query('SELECT * FROM questions WHERE created_by = :teacher_id AND id NOT IN 
                        (SELECT question_id FROM test_questions WHERE test_id = :test_id)');
        $this->db->bind(':teacher_id', $teacher_id);
        $this->db->bind(':test_id', $test_id);
        
        return $this->db->resultSet();
    }
}
?>

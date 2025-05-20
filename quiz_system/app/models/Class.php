<?php
class ClassModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Create a new class
    public function createClass($data) {
        $this->db->query('INSERT INTO classes (name, description) VALUES (:name, :description)');
        
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        
        // Execute
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    // Get class by ID
    public function getClassById($id) {
        $this->db->query('SELECT * FROM classes WHERE id = :id');
        $this->db->bind(':id', $id);
        
        $class = $this->db->single();
        
        if($class) {
            // Get students in this class
            $this->db->query('SELECT u.* FROM users u 
                            JOIN student_class sc ON u.id = sc.user_id 
                            WHERE sc.class_id = :class_id');
            $this->db->bind(':class_id', $id);
            $class->students = $this->db->resultSet();
            
            // Get number of students
            $class->student_count = count($class->students);
        }
        
        return $class;
    }
    
    // Get all classes
    public function getAllClasses() {
        $this->db->query('SELECT * FROM classes ORDER BY name');
        
        $classes = $this->db->resultSet();
        
        // Get student count for each class
        foreach($classes as $class) {
            $this->db->query('SELECT COUNT(*) as count FROM student_class WHERE class_id = :class_id');
            $this->db->bind(':class_id', $class->id);
            $count = $this->db->single();
            $class->student_count = $count->count;
        }
        
        return $classes;
    }
    
    // Update class
    public function updateClass($data) {
        $this->db->query('UPDATE classes SET name = :name, description = :description WHERE id = :id');
        
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':id', $data['id']);
        
        // Execute
        return $this->db->execute();
    }
    
    // Delete class
    public function deleteClass($id) {
        // Start transaction
        $this->db->query('START TRANSACTION');
        $this->db->execute();
        
        try {
            // Delete student-class relationships
            $this->db->query('DELETE FROM student_class WHERE class_id = :class_id');
            $this->db->bind(':class_id', $id);
            $this->db->execute();
            
            // Delete test assignments
            $this->db->query('DELETE FROM test_assignments WHERE class_id = :class_id');
            $this->db->bind(':class_id', $id);
            $this->db->execute();
            
            // Delete class
            $this->db->query('DELETE FROM classes WHERE id = :id');
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
    
    // Add student to class
    public function addStudentToClass($student_id, $class_id) {
        $this->db->query('INSERT INTO student_class (user_id, class_id) VALUES (:user_id, :class_id)');
        $this->db->bind(':user_id', $student_id);
        $this->db->bind(':class_id', $class_id);
        
        return $this->db->execute();
    }
    
    // Remove student from class
    public function removeStudentFromClass($student_id, $class_id) {
        $this->db->query('DELETE FROM student_class WHERE user_id = :user_id AND class_id = :class_id');
        $this->db->bind(':user_id', $student_id);
        $this->db->bind(':class_id', $class_id);
        
        return $this->db->execute();
    }
    
    // Get classes for a student
    public function getClassesByStudent($student_id) {
        $this->db->query('SELECT c.* FROM classes c 
                        JOIN student_class sc ON c.id = sc.class_id 
                        WHERE sc.user_id = :user_id');
        $this->db->bind(':user_id', $student_id);
        
        return $this->db->resultSet();
    }
}
?>

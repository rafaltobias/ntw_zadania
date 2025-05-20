<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Register user
    public function register($data) {
        $this->db->query('INSERT INTO users (username, password, name, role, email) VALUES (:username, :password, :name, :role, :email)');
        
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':email', $data['email']);
        
        // Execute
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
      // Login user
    public function login($username, $password) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        
        $row = $this->db->single();
        
        if($row) {
            // Bezpośrednie porównanie hasła (bez hashowania)
            if($password == $row->password) {
                return $row;
            }
        }
        
        return false;
    }
    
    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        
        $this->db->execute();
        
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        
        $this->db->execute();
        
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get user by ID
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    // Get all students
    public function getStudents() {
        $this->db->query('SELECT * FROM users WHERE role = :role ORDER BY name');
        $this->db->bind(':role', 'student');
        
        return $this->db->resultSet();
    }
    
    // Update user
    public function updateUser($data) {
        // If password is included
        if(!empty($data['password'])) {
            $this->db->query('UPDATE users SET username = :username, password = :password, name = :name, email = :email WHERE id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            $this->db->query('UPDATE users SET username = :username, name = :name, email = :email WHERE id = :id');
        }
        
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $data['id']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Delete user
    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get students not in a specific class
    public function getStudentsNotInClass($class_id) {
        $this->db->query('SELECT * FROM users WHERE role = :role AND id NOT IN 
                        (SELECT user_id FROM student_class WHERE class_id = :class_id)');
        $this->db->bind(':role', 'student');
        $this->db->bind(':class_id', $class_id);
        
        return $this->db->resultSet();
    }
    
    // Get all users from database
    public function getAllUsers() {
        $this->db->query('SELECT * FROM users ORDER BY username');
        return $this->db->resultSet();
    }
}
?>

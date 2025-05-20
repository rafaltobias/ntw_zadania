<?php
// Base Controller class that all controllers will extend
class Controller {
    // Load a model
    protected function model($model) {
        require_once ROOT_PATH . '/app/models/' . $model . '.php';
        return new $model();
    }
    
    // Load a view
    protected function view($view, $data = []) {
        if(file_exists(ROOT_PATH . '/app/views/' . $view . '.php')) {
            extract($data);
            require_once ROOT_PATH . '/app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
    
    // Redirect to another page
    protected function redirect($location) {
        header('Location: ' . URL_ROOT . '/' . $location);
        exit;
    }
    
    // Check if user is logged in
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Check if user is a teacher
    protected function isTeacher() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'teacher';
    }
    
    // Check if user is a student
    protected function isStudent() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'student';
    }
    
    // Require authentication to access a page
    protected function requireLogin() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
            return false;
        }
        return true;
    }
    
    // Require teacher role to access a page
    protected function requireTeacher() {
        if(!$this->isTeacher()) {
            $this->redirect('home/index');
            return false;
        }
        return true;
    }
    
    // Require student role to access a page
    protected function requireStudent() {
        if(!$this->isStudent()) {
            $this->redirect('home/index');
            return false;
        }
        return true;
    }
}
?>

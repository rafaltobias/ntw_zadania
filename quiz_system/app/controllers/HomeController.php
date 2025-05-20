<?php
class HomeController extends Controller {
    public function __construct() {
        // No need for authentication for home page
    }
    
    // Default home page
    public function index() {
        // If logged in, redirect to appropriate dashboard
        if($this->isLoggedIn()) {
            if($this->isTeacher()) {
                $this->redirect('teachers/dashboard');
            } else {
                $this->redirect('students/dashboard');
            }
        }
        
        $data = [
            'title' => 'Quiz System - Welcome',
            'description' => 'Test your knowledge with single-choice tests'
        ];
        
        $this->view('home/index', $data);
    }
    
    // About page
    public function about() {
        $data = [
            'title' => 'About Quiz System',
            'description' => 'Learn more about our quiz system'
        ];
        
        $this->view('home/about', $data);
    }
}
?>

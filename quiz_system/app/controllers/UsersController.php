<?php
class UsersController extends Controller {
    private $userModel;
    
    public function __construct() {
        $this->userModel = $this->model('User');
    }
    
    // User login form
    public function login() {
        // Check if already logged in
        if($this->isLoggedIn()) {
            if($this->isTeacher()) {
                $this->redirect('teachers/dashboard');
            } else {
                $this->redirect('students/dashboard');
            }
        }
        
        // Check if form is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => '',
                'title' => 'Login',
                'all_users' => $this->userModel->getAllUsers()
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
            
            // Check for user
            if(empty($data['username_err']) && empty($data['password_err'])) {
                // Attempt login
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                
                if($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Incorrect username or password';
                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => '',
                'title' => 'Login',
                'all_users' => $this->userModel->getAllUsers()
            ];
            
            // Load view
            $this->view('users/login', $data);
        }
    }
    
    // Create user session
    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_role'] = $user->role;
        
        if($user->role == 'teacher') {
            $this->redirect('teachers/dashboard');
        } else {
            $this->redirect('students/dashboard');
        }
    }
    
    // Logout and destroy session
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_role']);
        
        session_destroy();
        $this->redirect('users/login');
    }
    
    // User profile
    public function profile() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        $data = [
            'title' => 'Your Profile',
            'user' => $user
        ];
        
        $this->view('users/profile', $data);
    }
    
    // Edit profile
    public function edit() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'id' => $_SESSION['user_id'],
                'username' => trim($_POST['username']),
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'title' => 'Edit Profile'
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            } else {
                // Check if username exists
                $existingUser = $this->userModel->findUserByUsername($data['username']);
                if($existingUser && $existingUser->id != $_SESSION['user_id']) {
                    $data['username_err'] = 'Username already taken';
                }
            }
            
            // Validate name
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Check if email exists
                $existingUser = $this->userModel->findUserByEmail($data['email']);
                if($existingUser && $existingUser->id != $_SESSION['user_id']) {
                    $data['email_err'] = 'Email already taken';
                }
            }
            
            // Validate password if provided
            if(!empty($data['password'])) {
                if(strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }
                  if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
                
                // Hasło zostanie zachowane w niezmienionym formacie
            } else {
                // No password change
                unset($data['password']);
            }
            
            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Update user
                if($this->userModel->updateUser($data)) {
                    // Update session
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['user_username'] = $data['username'];
                    
                    // Redirect
                    $this->redirect('users/profile');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/edit', $data);
            }
        } else {
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            
            $data = [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'title' => 'Edit Profile'
            ];
            
            $this->view('users/edit', $data);
        }
    }
}
?>

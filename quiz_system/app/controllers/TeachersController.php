<?php
class TeachersController extends Controller {
    private $userModel;
    private $classModel;
    private $questionModel;
    private $testModel;
    private $resultModel;
    
    public function __construct() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        // Check if user is a teacher
        if(!$this->isTeacher()) {
            $this->redirect('home/index');
        }        $this->userModel = $this->model('User');
        $this->classModel = $this->model('ClassModel');
        $this->questionModel = $this->model('Question');
        $this->testModel = $this->model('Test');
        $this->resultModel = $this->model('Result');
    }
    
    // Teacher dashboard
    public function dashboard() {
        $teacher_id = $_SESSION['user_id'];
        
        // Get counts for dashboard
        $students = $this->userModel->getStudents();
        $classes = $this->classModel->getAllClasses();
        $questions = $this->questionModel->getQuestionsByTeacher($teacher_id);
        $tests = $this->testModel->getTestsByTeacher($teacher_id);
        
        $data = [
            'title' => 'Teacher Dashboard',
            'student_count' => count($students),
            'class_count' => count($classes),
            'question_count' => count($questions),
            'test_count' => count($tests),
            'recent_tests' => array_slice($tests, 0, 5) // Get only 5 most recent tests
        ];
        
        $this->view('teachers/dashboard', $data);
    }
    
    // Manage students
    public function students() {
        $students = $this->userModel->getStudents();
        
        $data = [
            'title' => 'Manage Students',
            'students' => $students
        ];
        
        $this->view('teachers/students/index', $data);
    }
    
    // Add new student
    public function addStudent() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'username' => trim($_POST['username']),
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role' => 'student',
                'username_err' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'title' => 'Add Student'
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            } else {
                // Check if username exists
                if($this->userModel->findUserByUsername($data['username'])) {
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
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email already taken';
                }
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            
            // Validate confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
              // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hasło zostanie zachowane w niezmienionym formacie
                
                // Register user
                if($this->userModel->register($data)) {
                    // Redirect
                    $this->redirect('teachers/students');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('teachers/students/add', $data);
            }
        } else {
            // Init data
            $data = [
                'username' => '',
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'title' => 'Add Student'
            ];
            
            // Load view
            $this->view('teachers/students/add', $data);
        }
    }
    
    // Edit student
    public function editStudent($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'id' => $id,
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
                'title' => 'Edit Student'
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            } else {
                // Check if username exists
                $existingUser = $this->userModel->findUserByUsername($data['username']);
                if($existingUser && $existingUser->id != $id) {
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
                if($existingUser && $existingUser->id != $id) {
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
                    // Redirect
                    $this->redirect('teachers/students');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('teachers/students/edit', $data);
            }
        } else {
            // Get student
            $student = $this->userModel->getUserById($id);
            
            if($student && $student->role == 'student') {
                // Init data
                $data = [
                    'id' => $student->id,
                    'username' => $student->username,
                    'name' => $student->name,
                    'email' => $student->email,
                    'password' => '',
                    'confirm_password' => '',
                    'username_err' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                    'title' => 'Edit Student'
                ];
                
                $this->view('teachers/students/edit', $data);
            } else {
                $this->redirect('teachers/students');
            }
        }
    }
    
    // Delete student
    public function deleteStudent($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get student
            $student = $this->userModel->getUserById($id);
            
            if($student && $student->role == 'student') {
                // Delete user
                if($this->userModel->deleteUser($id)) {
                    // Redirect
                    $this->redirect('teachers/students');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->redirect('teachers/students');
            }
        } else {
            $this->redirect('teachers/students');
        }
    }
    
    // Classes
    public function classes() {
        $classes = $this->classModel->getAllClasses();
        
        $data = [
            'title' => 'Manage Classes',
            'classes' => $classes
        ];
        
        $this->view('teachers/classes/index', $data);
    }
    
    // Add class
    public function addClass() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'title' => 'Add Class'
            ];
            
            // Validate name
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter class name';
            }
            
            // Make sure errors are empty
            if(empty($data['name_err'])) {
                // Add class
                if($this->classModel->createClass($data)) {
                    // Redirect
                    $this->redirect('teachers/classes');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('teachers/classes/add', $data);
            }
        } else {
            // Init data
            $data = [
                'name' => '',
                'description' => '',
                'name_err' => '',
                'title' => 'Add Class'
            ];
            
            // Load view
            $this->view('teachers/classes/add', $data);
        }
    }
    
    // View class
    public function viewClass($id) {
        // Get class
        $class = $this->classModel->getClassById($id);
        
        if($class) {
            // Get students not in this class
            $available_students = $this->userModel->getStudentsNotInClass($id);
            
            $data = [
                'title' => 'Class Details: ' . $class->name,
                'class' => $class,
                'available_students' => $available_students
            ];
            
            $this->view('teachers/classes/view', $data);
        } else {
            $this->redirect('teachers/classes');
        }
    }
    
    // Edit class
    public function editClass($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'title' => 'Edit Class'
            ];
            
            // Validate name
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter class name';
            }
            
            // Make sure errors are empty
            if(empty($data['name_err'])) {
                // Update class
                if($this->classModel->updateClass($data)) {
                    // Redirect
                    $this->redirect('teachers/classes');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('teachers/classes/edit', $data);
            }
        } else {
            // Get class
            $class = $this->classModel->getClassById($id);
            
            if($class) {
                // Init data
                $data = [
                    'id' => $class->id,
                    'name' => $class->name,
                    'description' => $class->description,
                    'name_err' => '',
                    'title' => 'Edit Class'
                ];
                
                $this->view('teachers/classes/edit', $data);
            } else {
                $this->redirect('teachers/classes');
            }
        }
    }
    
    // Delete class
    public function deleteClass($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete class
            if($this->classModel->deleteClass($id)) {
                // Redirect
                $this->redirect('teachers/classes');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('teachers/classes');
        }
    }
    
    // Add student to class
    public function addStudentToClass() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $student_id = $_POST['student_id'];
            $class_id = $_POST['class_id'];
            
            // Add student to class
            if($this->classModel->addStudentToClass($student_id, $class_id)) {
                // Redirect
                $this->redirect('teachers/viewClass/' . $class_id);
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('teachers/classes');
        }
    }
    
    // Remove student from class
    public function removeStudentFromClass($student_id, $class_id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Remove student from class
            if($this->classModel->removeStudentFromClass($student_id, $class_id)) {
                // Redirect
                $this->redirect('teachers/viewClass/' . $class_id);
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('teachers/classes');
        }
    }
    
    // Questions bank
    public function questions() {
        $questions = $this->questionModel->getQuestionsByTeacher($_SESSION['user_id']);
        
        $data = [
            'title' => 'Question Bank',
            'questions' => $questions
        ];
        
        $this->view('teachers/questions/index', $data);
    }
    
    // Add question
    public function addQuestion() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'content' => trim($_POST['content']),
                'answers' => [
                    trim($_POST['answer1']),
                    trim($_POST['answer2']),
                    trim($_POST['answer3']),
                    trim($_POST['answer4'])
                ],
                'correct_answer' => $_POST['correct_answer'],
                'created_by' => $_SESSION['user_id'],
                'content_err' => '',
                'answers_err' => '',
                'correct_answer_err' => '',
                'title' => 'Add Question'
            ];
            
            // Validate content
            if(empty($data['content'])) {
                $data['content_err'] = 'Please enter question content';
            }
            
            // Validate answers
            $empty_answers = false;
            foreach($data['answers'] as $answer) {
                if(empty($answer)) {
                    $empty_answers = true;
                    break;
                }
            }
            
            if($empty_answers) {
                $data['answers_err'] = 'Please provide all answer options';
            }
            
            // Validate correct answer
            if(!isset($data['correct_answer']) || $data['correct_answer'] < 0 || $data['correct_answer'] > 3) {
                $data['correct_answer_err'] = 'Please select the correct answer';
            }
            
            // Make sure errors are empty
            if(empty($data['content_err']) && empty($data['answers_err']) && empty($data['correct_answer_err'])) {
                // Add question
                if($this->questionModel->addQuestion($data)) {
                    // Redirect
                    $this->redirect('teachers/questions');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('teachers/questions/add', $data);
            }
        } else {
            // Init data
            $data = [
                'content' => '',
                'answers' => ['', '', '', ''],
                'correct_answer' => '',
                'content_err' => '',
                'answers_err' => '',
                'correct_answer_err' => '',
                'title' => 'Add Question'
            ];
            
            // Load view
            $this->view('teachers/questions/add', $data);
        }
    }
    
    // View question
    public function viewQuestion($id) {
        // Get question
        $question = $this->questionModel->getQuestionById($id);
        
        if($question && $question->created_by == $_SESSION['user_id']) {
            $data = [
                'title' => 'Question Details',
                'question' => $question
            ];
            
            $this->view('teachers/questions/view', $data);
        } else {
            $this->redirect('teachers/questions');
        }
    }
    
    // Edit question
    public function editQuestion($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'id' => $id,
                'content' => trim($_POST['content']),
                'answers' => [
                    trim($_POST['answer1']),
                    trim($_POST['answer2']),
                    trim($_POST['answer3']),
                    trim($_POST['answer4'])
                ],
                'correct_answer' => $_POST['correct_answer'],
                'content_err' => '',
                'answers_err' => '',
                'correct_answer_err' => '',
                'title' => 'Edit Question'
            ];
            
            // Validate content
            if(empty($data['content'])) {
                $data['content_err'] = 'Please enter question content';
            }
            
            // Validate answers
            $empty_answers = false;
            foreach($data['answers'] as $answer) {
                if(empty($answer)) {
                    $empty_answers = true;
                    break;
                }
            }
            
            if($empty_answers) {
                $data['answers_err'] = 'Please provide all answer options';
            }
            
            // Validate correct answer
            if(!isset($data['correct_answer']) || $data['correct_answer'] < 0 || $data['correct_answer'] > 3) {
                $data['correct_answer_err'] = 'Please select the correct answer';
            }
            
            // Make sure errors are empty
            if(empty($data['content_err']) && empty($data['answers_err']) && empty($data['correct_answer_err'])) {
                // Update question
                if($this->questionModel->updateQuestion($data)) {
                    // Redirect
                    $this->redirect('teachers/questions');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('teachers/questions/edit', $data);
            }
        } else {
            // Get question
            $question = $this->questionModel->getQuestionById($id);
            
            if($question && $question->created_by == $_SESSION['user_id']) {
                // Get correct answer index
                $correct_answer_index = 0;
                foreach($question->answers as $index => $answer) {
                    if($answer->is_correct) {
                        $correct_answer_index = $index;
                        break;
                    }
                }
                
                // Extract answer texts
                $answers = [];
                foreach($question->answers as $answer) {
                    $answers[] = $answer->content;
                }
                
                // Init data
                $data = [
                    'id' => $question->id,
                    'content' => $question->content,
                    'answers' => $answers,
                    'correct_answer' => $correct_answer_index,
                    'content_err' => '',
                    'answers_err' => '',
                    'correct_answer_err' => '',
                    'title' => 'Edit Question'
                ];
                
                $this->view('teachers/questions/edit', $data);
            } else {
                $this->redirect('teachers/questions');
            }
        }
    }
    
    // Delete question
    public function deleteQuestion($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get question
            $question = $this->questionModel->getQuestionById($id);
            
            if($question && $question->created_by == $_SESSION['user_id']) {
                // Delete question
                if($this->questionModel->deleteQuestion($id)) {
                    // Redirect
                    $this->redirect('teachers/questions');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->redirect('teachers/questions');
            }
        } else {
            $this->redirect('teachers/questions');
        }
    }
    
    // Tests
    public function tests() {
        $tests = $this->testModel->getTestsByTeacher($_SESSION['user_id']);
        
        $data = [
            'title' => 'Manage Tests',
            'tests' => $tests
        ];
        
        $this->view('teachers/tests/index', $data);
    }
    
    // Add test
    public function addTest() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'questions' => isset($_POST['questions']) ? $_POST['questions'] : [],
                'created_by' => $_SESSION['user_id'],
                'title_err' => '',
                'questions_err' => '',
                'page_title' => 'Create Test'
            ];
            
            // Validate title
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter test title';
            }
            
            // Validate questions
            if(empty($data['questions'])) {
                $data['questions_err'] = 'Please select at least one question';
            }
            
            // Make sure errors are empty
            if(empty($data['title_err']) && empty($data['questions_err'])) {
                // Add test
                if($this->testModel->createTest($data)) {
                    // Redirect
                    $this->redirect('teachers/tests');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Get all questions by teacher for selection
                $questions = $this->questionModel->getQuestionsByTeacher($_SESSION['user_id']);
                $data['all_questions'] = $questions;
                
                // Load view with errors
                $this->view('teachers/tests/add', $data);
            }
        } else {
            // Get all questions by teacher
            $questions = $this->questionModel->getQuestionsByTeacher($_SESSION['user_id']);
            
            // Init data
            $data = [
                'title' => '',
                'description' => '',
                'questions' => [],
                'all_questions' => $questions,
                'title_err' => '',
                'questions_err' => '',
                'page_title' => 'Create Test'
            ];
            
            // Load view
            $this->view('teachers/tests/add', $data);
        }
    }
    
    // View test
    public function viewTest($id) {
        // Get test
        $test = $this->testModel->getTestById($id);
        
        if($test && $test->created_by == $_SESSION['user_id']) {
            // Get results for this test
            $results = $this->resultModel->getResultsByTest($id);
            
            // Get classes
            $classes = $this->classModel->getAllClasses();
            
            // Get students not assigned to this test
            $students = $this->userModel->getStudents();
            
            $data = [
                'title' => 'Test Details: ' . $test->title,
                'test' => $test,
                'results' => $results,
                'classes' => $classes,
                'students' => $students
            ];
            
            $this->view('teachers/tests/view', $data);
        } else {
            $this->redirect('teachers/tests');
        }
    }
    
    // Edit test
    public function editTest($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'questions' => isset($_POST['questions']) ? $_POST['questions'] : [],
                'title_err' => '',
                'questions_err' => '',
                'page_title' => 'Edit Test'
            ];
            
            // Validate title
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter test title';
            }
            
            // Validate questions
            if(empty($data['questions'])) {
                $data['questions_err'] = 'Please select at least one question';
            }
            
            // Make sure errors are empty
            if(empty($data['title_err']) && empty($data['questions_err'])) {
                // Update test
                if($this->testModel->updateTest($data)) {
                    // Redirect
                    $this->redirect('teachers/tests');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Get all questions by teacher for selection
                $questions = $this->questionModel->getQuestionsByTeacher($_SESSION['user_id']);
                $data['all_questions'] = $questions;
                
                // Load view with errors
                $this->view('teachers/tests/edit', $data);
            }
        } else {
            // Get test
            $test = $this->testModel->getTestById($id);
            
            if($test && $test->created_by == $_SESSION['user_id']) {
                // Get all questions by teacher
                $questions = $this->questionModel->getQuestionsByTeacher($_SESSION['user_id']);
                
                // Get selected question IDs
                $selected_questions = [];
                foreach($test->questions as $question) {
                    $selected_questions[] = $question->id;
                }
                
                // Init data
                $data = [
                    'id' => $test->id,
                    'title' => $test->title,
                    'description' => $test->description,
                    'questions' => $selected_questions,
                    'all_questions' => $questions,
                    'title_err' => '',
                    'questions_err' => '',
                    'page_title' => 'Edit Test'
                ];
                
                $this->view('teachers/tests/edit', $data);
            } else {
                $this->redirect('teachers/tests');
            }
        }
    }
    
    // Delete test
    public function deleteTest($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get test
            $test = $this->testModel->getTestById($id);
            
            if($test && $test->created_by == $_SESSION['user_id']) {
                // Delete test
                if($this->testModel->deleteTest($id)) {
                    // Redirect
                    $this->redirect('teachers/tests');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->redirect('teachers/tests');
            }
        } else {
            $this->redirect('teachers/tests');
        }
    }
    
    // Assign test to student
    public function assignTestToStudent() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $test_id = $_POST['test_id'];
            $student_id = $_POST['student_id'];
            
            // Assign test to student
            if($this->testModel->assignTestToStudent($test_id, $student_id)) {
                // Redirect
                $this->redirect('teachers/viewTest/' . $test_id);
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('teachers/tests');
        }
    }
    
    // Assign test to class
    public function assignTestToClass() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $test_id = $_POST['test_id'];
            $class_id = $_POST['class_id'];
            
            // Assign test to class
            if($this->testModel->assignTestToClass($test_id, $class_id)) {
                // Redirect
                $this->redirect('teachers/viewTest/' . $test_id);
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('teachers/tests');
        }
    }
    
    // View test results
    public function results() {
        // Get all results for teacher
        $results = $this->resultModel->getResultsByTeacher($_SESSION['user_id']);
        
        $data = [
            'title' => 'Test Results',
            'results' => $results
        ];
        
        $this->view('teachers/results/index', $data);
    }
    
    // View result details
    public function viewResult($id) {
        // Get result
        $result = $this->resultModel->getResultById($id);
        
        // Verify teacher owns the test
        if($result) {
            $data = [
                'title' => 'Result Details',
                'result' => $result
            ];
            
            $this->view('teachers/results/view', $data);
        } else {
            $this->redirect('teachers/results');
        }
    }
}
?>

<?php
class StudentsController extends Controller {
    private $userModel;
    private $classModel;
    private $testModel;
    private $questionModel;
    private $resultModel;
    
    public function __construct() {
        if(!$this->isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        // Check if user is a student
        if(!$this->isStudent()) {
            $this->redirect('home/index');
        }        $this->userModel = $this->model('User');
        $this->classModel = $this->model('ClassModel');
        $this->testModel = $this->model('Test');
        $this->questionModel = $this->model('Question');
        $this->resultModel = $this->model('Result');
    }
    
    // Student dashboard
    public function dashboard() {
        $student_id = $_SESSION['user_id'];
        
        // Get assigned tests
        $tests = $this->testModel->getTestsAssignedToStudent($student_id);
        
        // Get completed tests
        $completed_tests = $this->testModel->getCompletedTestsByStudent($student_id);
        
        // Get classes
        $classes = $this->classModel->getClassesByStudent($student_id);
          $data = [
            'title' => 'Student Dashboard',
            'tests' => $tests,
            'available_tests' => $tests,
            'completed_tests' => $completed_tests,
            'test_count' => count($tests),
            'completed_count' => count($completed_tests),
            'class_count' => count($classes)
        ];
        
        $this->view('students/dashboard', $data);
    }
    
    // View all available tests
    public function tests() {
        $student_id = $_SESSION['user_id'];
        
        // Get assigned tests
        $tests = $this->testModel->getTestsAssignedToStudent($student_id);
        
        $data = [
            'title' => 'Available Tests',
            'tests' => $tests
        ];
        
        $this->view('students/tests/index', $data);
    }
    
    // Take a test
    public function takeTest($id) {
        $student_id = $_SESSION['user_id'];
        
        // Check if test is assigned to student
        $assigned_tests = $this->testModel->getTestsAssignedToStudent($student_id);
        $is_assigned = false;
        
        foreach($assigned_tests as $test) {
            if($test->id == $id) {
                $is_assigned = true;
                break;
            }
        }
        
        if($is_assigned) {
            // Get test details
            $test = $this->testModel->getTestById($id);
            
            // Shuffle questions
            shuffle($test->questions);
            
            // Prepare questions with shuffled answers
            $prepared_questions = [];
            foreach($test->questions as $question) {
                // Get answers for this question
                $question_details = $this->questionModel->getQuestionById($question->id);
                
                // Shuffle answers
                $answers = $question_details->answers;
                shuffle($answers);
                
                // Create question data
                $q = [
                    'id' => $question->id,
                    'content' => $question->content,
                    'answers' => $answers
                ];
                
                $prepared_questions[] = $q;
            }
            
            $data = [
                'title' => 'Taking Test: ' . $test->title,
                'test' => $test,
                'questions' => $prepared_questions
            ];
            
            $this->view('students/tests/take', $data);
        } else {
            $this->redirect('students/tests');
        }
    }
    
    // Submit test answers
    public function submitTest() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $test_id = $_POST['test_id'];
            $answers = [];
            $score = 0;
            
            // Get test
            $test = $this->testModel->getTestById($test_id);
            
            // Process answers
            foreach($test->questions as $question) {
                $question_id = $question->id;
                $answer_id = isset($_POST['question_' . $question_id]) ? $_POST['question_' . $question_id] : null;
                
                if($answer_id) {
                    $answers[$question_id] = $answer_id;
                    
                    // Check if answer is correct
                    $correct_answer = $this->questionModel->getCorrectAnswer($question_id);
                    if($correct_answer && $correct_answer->id == $answer_id) {
                        $score++;
                    }
                }
            }
            
            // Prepare data for submission
            $data = [
                'user_id' => $_SESSION['user_id'],
                'test_id' => $test_id,
                'score' => $score,
                'answers' => $answers
            ];
            
            // Submit test results
            $result_id = $this->testModel->submitTestResult($data);
            
            if($result_id) {
                $this->redirect('students/viewResult/' . $result_id);
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('students/tests');
        }
    }
    
    // View completed tests
    public function completedTests() {
        $student_id = $_SESSION['user_id'];
        
        // Get completed tests
        $completed_tests = $this->testModel->getCompletedTestsByStudent($student_id);
        
        $data = [
            'title' => 'Completed Tests',
            'tests' => $completed_tests
        ];
        
        $this->view('students/tests/completed', $data);
    }
    
    // View test result
    public function viewResult($id) {
        $student_id = $_SESSION['user_id'];
        
        // Get result
        $result = $this->resultModel->getResultById($id);
        
        // Verify student owns the result
        if($result && $result->user_id == $student_id) {
            $data = [
                'title' => 'Test Result',
                'result' => $result
            ];
            
            $this->view('students/tests/result', $data);
        } else {
            $this->redirect('students/completedTests');
        }
    }
    
    // View classes student is in
    public function classes() {
        $student_id = $_SESSION['user_id'];
        
        // Get classes
        $classes = $this->classModel->getClassesByStudent($student_id);
        
        $data = [
            'title' => 'Your Classes',
            'classes' => $classes
        ];
        
        $this->view('students/classes/index', $data);
    }
    
    // View class details
    public function viewClass($id) {
        $student_id = $_SESSION['user_id'];
        
        // Get class
        $class = $this->classModel->getClassById($id);
        
        // Check if student is in this class
        $classes = $this->classModel->getClassesByStudent($student_id);
        $is_in_class = false;
        
        foreach($classes as $c) {
            if($c->id == $id) {
                $is_in_class = true;
                break;
            }
        }
        
        if($class && $is_in_class) {
            $data = [
                'title' => 'Class: ' . $class->name,
                'class' => $class
            ];
            
            $this->view('students/classes/view', $data);
        } else {
            $this->redirect('students/classes');
        }
    }
}
?>

<?php
// Main entry point for the application
session_start();
define('ROOT_PATH', dirname(__FILE__));

// Include database configuration
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/config/config.php';

// Include core files for MVC structure
require_once ROOT_PATH . '/app/core/Router.php';
require_once ROOT_PATH . '/app/core/Controller.php';
require_once ROOT_PATH . '/app/core/Database.php';

// Include all models
require_once ROOT_PATH . '/app/models/User.php';
require_once ROOT_PATH . '/app/models/Question.php';
require_once ROOT_PATH . '/app/models/Test.php';
require_once ROOT_PATH . '/app/models/ClassModel.php';
require_once ROOT_PATH . '/app/models/Result.php';

// Initialize the router and process the URL
$router = new Router();
$router->route();
?>

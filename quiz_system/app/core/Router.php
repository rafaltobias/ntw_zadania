<?php
// Router class to handle URL routing and dispatching to controllers
class Router {
    protected $controller = 'HomeController';
    protected $action = 'index';
    protected $params = [];
    protected $url;

    public function __construct() {
        $this->url = $this->parseUrl();
    }
    
    public function route() {
        // Check if controller exists
        if(isset($this->url[0])) {
            if(file_exists(ROOT_PATH . '/app/controllers/' . ucfirst($this->url[0]) . 'Controller.php')) {
                $this->controller = ucfirst($this->url[0]) . 'Controller';
                unset($this->url[0]);
            }
        }
        
        // Include the controller
        require_once ROOT_PATH . '/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        
        // Check if action exists
        if(isset($this->url[1])) {
            if(method_exists($this->controller, $this->url[1])) {
                $this->action = $this->url[1];
                unset($this->url[1]);
            }
        }
        
        // Get params from URL
        $this->params = $this->url ? array_values($this->url) : [];
        
        // Call the controller's action with parameters
        call_user_func_array([$this->controller, $this->action], $this->params);
    }
    
    // Parse URL and return parts as array
    protected function parseUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
?>

<?php

namespace classes;

class Core {
    public string $defaultLayoutPath = 'layouts/index.php';
    public string $module = '';
    public string $action = '';
    public Database $db;
    private static ?Core $instance = null;
    protected Template $mainTemplate;
    public Session $session;

    public int $httpStatusCode = 200;

    private function __construct() {

        $config = Config::getInstance();

        $host = $config->dbhost;
        $name = $config->dbname;
        $user = $config->dbuser;
        $pass = $config->dbpass;

        try {
            $this->db = new Database($host, $name, $user, $pass);
        }
        catch (\RuntimeException $e) {
            error_log("Core initialization failed: " . $e->getMessage());
            $this->error(500);
            die;
        }

        $this->mainTemplate = new Template($this->defaultLayoutPath);

        $this->session = new Session();
    }

    public static function getInstance(): Core {
        if (is_null(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    public function init(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function run(): void {
        $route = $_GET['route'] ?? '';
        $route_parts = explode('/', $route);

        if (empty($route_parts[0])) {
            $this->module = 'site';
            $this->action = 'index';
            $params = [];
        }
        else {
            $this->module = array_shift($route_parts);
            $this->action = array_shift($route_parts) ?? 'index';
            $params = $route_parts;
        }

        $class_name = 'controllers\\' . ucfirst($this->module) . 'Controller';
        $method = $this->action . 'Action';

        if (!class_exists($class_name)) {
            $this->error(404);
        }

        try {
            $controller = new $class_name();
        }
        catch (\Throwable $e) {
            error_log("Error creating controller '{$class_name}': " . $e->getMessage());
            $this->error(500);
        }

        if (!method_exists($controller, $method)) {
            $this->error(404);
        }

        try {
            $data = call_user_func_array([$controller, $method], $params);
        }
        catch (\Throwable $e) {
            error_log("Error executing controller method '{$class_name}::{$method}': " . $e->getMessage());
            $this->error(500);
        }

        if (!is_array($data)) {
            error_log("Controller method {$class_name}::{$method} did not return an array. Returned type: " . gettype($data));
            $data = [];
        }

        $this->mainTemplate->addParams($data);
        $this->mainTemplate->display();
    }

    public function done(): void {
    }

    public function error(int $code): void {
        $this->httpStatusCode = $code;
        ob_clean();
        http_response_code($code);

        try {
            $errorTemplate = new Template("views/error/{$code}.php");
            $errorMessage = "Something went wrong! Error: {$code}.";
            if ($code === 404) {
                $errorMessage = "Page not found.";
            }
            elseif ($code === 500) {
                $errorMessage = "Internal server error.";
            }
            $errorTemplate->addParam('errorMessage', $errorMessage);

            $errorTemplate->display();
        }
        catch (\RuntimeException $e) {
            error_log("Error template not found or rendering failed: " . $e->getMessage());
            if (!headers_sent()) {
                http_response_code($code);
            }
            echo "<h1>Error {$code}</h1><p>An unexpected error occurred.</p>";
        }
        die;
    }
}
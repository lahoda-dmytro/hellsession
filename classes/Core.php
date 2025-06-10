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
            $errorMessage = "Something went wrong! Error: {$code}.";
            $pageTitle = "Error " . $code;

            switch ($code) {
                case 401:
                    $errorMessage = "You need to be authenticated to access this resource.";
                    $pageTitle = "401 Unauthorized";
                    break;
                case 403:
                    $errorMessage = "You don't have permission to access this resource.";
                    $pageTitle = "403 Forbidden";
                    break;
                case 404:
                    $errorMessage = "The page you are looking for does not exist.";
                    $pageTitle = "404 Not Found";
                    break;
                case 405:
                    $errorMessage = "The requested method is not allowed for this URL.";
                    $pageTitle = "405 Method Not Allowed";
                    break;
                case 500:
                    $errorMessage = "An internal server error occurred.";
                    $pageTitle = "500 Internal Server Error";
                    break;
                default:
                    $errorMessage = "An unexpected error occurred. Error Code: " . $code;
                    $pageTitle = "Error " . $code;
                    break;
            }

            $errorContentTemplatePath = "views/error/{$code}.php";
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $errorContentTemplatePath)) {
                $errorContentTemplatePath = "views/error/default.php";
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $errorContentTemplatePath)) {
                    throw new \RuntimeException("Default error template not found!");
                }
            }

            $templateForErrorContent = new Template($errorContentTemplatePath);
            $templateForErrorContent->addParam('errorMessage', $errorMessage);
            $renderedErrorContent = $templateForErrorContent->render();

            $this->mainTemplate->addParam('Title', $pageTitle);
            $this->mainTemplate->addParam('Content', $renderedErrorContent);
            $this->mainTemplate->addParam('isErrorPage', true);

            $this->mainTemplate->display();

        } catch (\Throwable $e) {
            error_log("Critical error during error page rendering: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
            if (!headers_sent()) {
                http_response_code($code);
            }
            echo "<h1>Error {$code}</h1><p>An unexpected error occurred while trying to display the error page. Please try again later.</p>";
        }
        die;
    }
}
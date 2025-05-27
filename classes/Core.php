<?php

namespace classes;

class Core
{
        public string $module = '';
        public string $action = '';
        private static $instance = null;
        protected Template $mainTemplate;
        private function __construct(){
            $this->mainTemplate = new Template("layouts/index.php");
        }

        public static function getInstance(){
            if(is_null(self::$instance)){
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function init(){
            session_start();
        }
        public function run(){
            $route = $_GET['route'] ?? '';
            $route_parts = explode('/', $route);

            $this->module = array_shift($route_parts) ?? '';
            $this->action = array_shift($route_parts) ?? '';

            $class_name = 'controllers\\' . ucfirst($this->module) . 'Controller';
            $method = $this->action . 'Action';


            if (empty($this->module)) {
                $module = 'products'; // 'home', 'main'
            }
            if (empty($this->action)) {
                $action = 'list';
            }


            if(!class_exists($class_name)) {
                $this->error(404);
                return;
            }
            $controller = new $class_name();

            if(!method_exists($controller, $method)) {
                $this->error(404);
                return;
            }

            if (!empty($params)) {
                $data = call_user_func_array([$controller, $method], $params);
            } else {
                $data = $controller->$method();
            }

            if (!is_array($data)) {
                $data = [];
            }

            $this->mainTemplate->addParams($data);

        }

        public function done(){
            $this->mainTemplate->display();
        }

        public function error(int $code){
            http_response_code($code);

            $errorTemplate = new Template("views/error/{$code}.php");
            $errorTemplate->addParam('errorMessage', "Something went wrong! Error: {$code}");
            ob_clean();
            $errorTemplate->display();
            die;
        }
}
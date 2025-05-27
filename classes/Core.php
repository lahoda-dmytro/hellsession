<?php

namespace classes;

class Core
{
        private static $instance = null;
        protected Template $mainTemplate;
        private function __construct(){
            $this->mainTemplate = new Template("layout/index.php");
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

            $module = array_shift($route_parts);
            $action = array_shift($route_parts);

            if (empty($module)) {
                $module = 'products'; // 'home', 'main'
            }
            if (empty($action)) {
                $action = 'list';
            }

            $class_name = 'controllers\\' . ucfirst($module) . 'Controller';
            $method = $action . 'Action';

            if(!class_exists($class_name)) {
                $this->error(404);
                return;
            }
            $controller = new $class_name();

            if(!method_exists($controller, $method)) {
                $this->error(404);
                return;
            }
            $this->mainTemplate = new Template("layout/index.php");

            if (!empty($params)) {
                $data = call_user_func_array([$controller, $method], $params);
            } else {
                $data = $controller->$method();
            }

            if (!is_array($data)) {
                $data = [];
            }

            $this->mainTemplate->addParams($data);

//
//            $data = $controller->$method();
//            $this->mainTemplate->addParams($data);

//            $data = $controller->$method();
//            $this->mainTemplate->addParams($data);


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
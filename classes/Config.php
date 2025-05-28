<?php

namespace classes;

class Config {

    protected array $params = [];
    protected static ?Config $instance = null;
    private function __construct() {
        /** @var TYPE_NAME $Config */

        $directory = 'config';
        $config_files = scandir($directory);

        foreach ($config_files as $config_file) {
            if (substr($config_file, -4) === '.php' && $config_file !== '.' && $config_file !== '..') {
                $path = $directory.'/'.$config_file;

                $config_data = include $path;

                if (is_array($config_data)) {
                    $this->params = array_merge($this->params, $config_data);
                } else {
                    error_log("Config file '{$path}' did not return an array.");
                }
            }
        }
    }

    public static function getInstance(): Config {
        if (is_null(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    public function __set($name, $value) {
        $this->params[$name] = $value;
    }
    public function __get($name): mixed {
        return $this->params[$name] ?? null;
    }
    public function getAll(): array {
        return $this->params;
    }

    public function get(string $key, mixed $default = null): mixed {
        return $this->params[$key] ?? $default;
    }

}
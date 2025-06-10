<?php

namespace classes;

class Session {
    private static ?Session $instance = null;

    public function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    public function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public function remove(string $key): void {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function clear(): void {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn(): bool {
        return $this->get('user_id') !== null;
    }

    public static function getInstance(): Session {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
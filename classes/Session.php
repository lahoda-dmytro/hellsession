<?php

namespace classes;

class Session {
    public function set($name, $value): void {
        $_SESSION[$name] = $value;
    }

    public function get($name) {
        return $_SESSION[$name] ?? null;
    }

    public function has($name): bool {
        return isset($_SESSION[$name]);
    }

    public function remove($name): void {
        unset($_SESSION[$name]);
    }

    public function clear(): void {
        session_unset();
    }

    public function all(): array {
        return $_SESSION;
    }

    public function setValues(array $assocArray): void {
        foreach ($assocArray as $key => $value) {
            $this->set($key, $value);
        }
    }
}

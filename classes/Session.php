<?php

namespace classes;

class Session {
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }
    public function get($name) {
        return $_SESSION[$name];
    }
    public function setValues($assocArray) {
        foreach ($assocArray as $key => $value) {
            $this->set($key, $value);
        }
    }

}
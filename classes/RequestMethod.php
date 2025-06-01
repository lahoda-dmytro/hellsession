<?php

namespace classes;

class RequestMethod {
    public array $array = [];

    public function __construct(array $data) {
        $this->array = $data;
    }

    public function __get(string $name): mixed {
        return $this->array[$name] ?? null;
    }

    public function getAll(): array {
        return $this->array;
    }

    public function has(string $name): bool {
        return isset($this->array[$name]);
    }
}
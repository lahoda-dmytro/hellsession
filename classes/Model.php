<?php

namespace classes;
use classes\Core;

class Model {
    protected array $fieldArray = [];
    protected string $table = '';
    protected string $primaryKey  = 'id';
    protected array $fillable = [];


    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            $this->fieldArray[$key] = $value;
        }
    }
    public function __set(string $name, mixed $value): void {
        $this->fieldArray[$name] = $value;
    }
    public function __get(string $name): mixed {
        return $this->fieldArray[$name] ?? null;
    }

    public function toArray(): array {
        return $this->fieldArray;
    }

    public function save(): bool {

        $db = Core::getInstance()->db;
        $dataToSave = $this->filter($this->fieldArray);

        $id = $this->{$this->primaryKey} ?? null;

        if ($id) {
            $rowsAffected = $db->update($this->table, $dataToSave, [$this->primaryKey => $id]);
            return $rowsAffected > 0;
        } else {
            $lastInsertId = $db->insert($this->table, $dataToSave);
            if ($lastInsertId) {
                $this->{$this->primaryKey} = $lastInsertId;
                return true;
            }
            return false;
        }
    }

    protected function filter(array $data): array {
        if (empty($this->fillable)) {
            return $data;
        }

        $filtered = [];
        foreach ($this->fillable as $field) {
            if (array_key_exists($field, $data)) {
                $filtered[$field] = $data[$field];
            }
        }
        return $filtered;
    }

    public static function find(mixed $id): ?static {
        $instance = new static();

        $db = Core::getInstance()->db;
        $result = $db->select($instance->table, '*', [$instance->primaryKey => $id]);

        if (!empty($result)) {
            return new static($result[0]);
        }
        return null;
    }

    public static function all(): array {
        $instance = new static();

        $db = Core::getInstance()->db;
        $results = $db->select($instance->table);

        $models = [];
        foreach ($results as $data) {
            $models[] = new static($data);
        }
        return $models;
    }

    public static function where(array $where): array {
        $instance = new static();

        $db = Core::getInstance()->db;
        $results = $db->select($instance->table, '*', $where);

        $models = [];
        foreach ($results as $data) {
            $models[] = new static($data);
        }
        return $models;
    }

}
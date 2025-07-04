<?php

namespace classes;

class Model {
    protected array $fieldArray = [];
    protected string $table = '';
    protected string $primaryKey = 'id';
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

    public static function delete(mixed $conditions): int {
        $instance = new static();

        $db = Core::getInstance()->db;

        if (is_array($conditions)) {
            return $db->delete($instance->table, $conditions);
        } else {
            return $db->delete($instance->table, [$instance->primaryKey => $conditions]);
        }
    }

     public function save(): bool {
        $db = Core::getInstance()->db;
        $dataToSave = $this->filterFillable($this->fieldArray);

        error_log('Data to save: ' . print_r($dataToSave, true));
        error_log('Fillable fields: ' . print_r($this->fillable, true));
        error_log('Original field array: ' . print_r($this->fieldArray, true));

        $id = $this->{$this->primaryKey} ?? null;

        if ($id) {
            $rowsAffected = $db->update($this->table, $dataToSave, [$this->primaryKey => $id]);
            error_log('Update result - rows affected: ' . $rowsAffected);
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

    protected function filterFillable(array $data): array {
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

    public static function findOneWhere(array $where): ?static {
        $instance = new static();

        $db = Core::getInstance()->db;
        $results = $db->select($instance->table, '*', $where, '', 1);

        if (!empty($results)) {
            return new static($results[0]);
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

    public static function query(string $query, array $params = []): array {
        $db = Core::getInstance()->db;
        return $db->query($query, $params);
    }

    public static function findAllWhere(array $where = [], array $orderBy = [], int $limit = 0): array
    {
        $instance = new static();
        $db = Core::getInstance()->db;

        $orderByString = '';
        if (!empty($orderBy)) {
            $orderByParts = [];
            foreach ($orderBy as $column => $direction) {
                $orderByParts[] = "`{$column}` " . strtoupper($direction);
            }
            $orderByString = implode(', ', $orderByParts);
        }

        $results = $db->select($instance->table, '*', $where, $orderByString, $limit);

        $models = [];
        foreach ($results as $data) {
            $models[] = new static($data);
        }
        return $models;
    }
}
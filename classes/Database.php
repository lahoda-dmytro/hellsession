<?php

namespace classes;

use PDO;
use PDOException;

class Database {
    public ?PDO $pdo = null;
    public function __construct(string $host, string $name, string $user, string $pass) {
        try {
            $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // режим помилок: кидати винятки
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // режим вибірки: асоціативний масив
                PDO::ATTR_EMULATE_PREPARES   => false,                // вимкнути емуляцію підготовлених запитів
            ];
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage() . " - DSN: " . $dsn . " - User: " . $user);
            throw new \RuntimeException("Database connection error. Please try again later.");
        }
    }

    public function getConnection(): ?PDO {
        return $this->pdo;
    }
    public function select($table, $fields = "*", $where = null) {
        if (is_array($fields)) {
            $fields_string = implode(',', $fields);
        } else if (is_string($fields)) {
            $fields_string = $fields;
        } else {
            $fields_string = "*";
        }

        $sql = "SELECT {$fields_string} FROM {$table}";
        if ($where !== null) {
            $sql .= " WHERE {$where}";
        }
        return $this->pdo->query($sql)->fetchAll(); // Приклад для простого запиту
    }

}
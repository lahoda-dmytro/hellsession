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
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->pdo = new PDO($dsn, $user, $pass, $options);
            error_log("DB_CONNECTION_INFO: Connected to DSN: {$dsn}, User: {$user}. Connection established successfully.");
        } catch (PDOException $e) {
            error_log("DATABASE_CONNECTION_ERROR: Database connection failed: " . $e->getMessage() . " - DSN: " . $dsn . " - User: " . $user);
            throw new \RuntimeException("Database connection error. Please try again later.");
        }
    }

    public function getConnection(): ?PDO {
        return $this->pdo;
    }

    protected function where(array $where): array {
        $whereClauses = [];
        $params = [];
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $whereClauses[] = "`{$key}` = :{$key}";
                $params[":{$key}"] = $value;
            }
        }
        return [implode(' AND ', $whereClauses), $params];
    }

    public function select(string $table, $fields = "*", array $where = []): array {
        if (is_array($fields)) {
            $fields_string = implode(', ', $fields);
        } else {
            $fields_string = $fields;
        }

        $sql = "SELECT {$fields_string} FROM `{$table}`";

        list($whereClause, $params) = $this->where($where);

        if (!empty($whereClause)) {
            $sql .= " WHERE " . $whereClause;
        }
        try {
            $sth = $this->pdo->prepare($sql);
            $sth->execute($params);
            $results = $sth->fetchAll();

            return $results;
        } catch (PDOException $e) {
            error_log("DB_SELECT_ERROR: Database SELECT error for table '{$table}': " . $e->getMessage() . " - SQL: " . $sql);
            throw $e;
        }
    }

    public function insert(string $table, array $row_to_insert): int {
        $fields_list = implode(", ", array_keys($row_to_insert));
        $params_array = [];
        foreach ($row_to_insert as $key => $value) {
            $params_array[] = ":{$key}";
        }
        $params_list = implode(", ", $params_array);
        $sql = "INSERT INTO `{$table}` ({$fields_list}) VALUES ({$params_list})";
        $sth = $this->pdo->prepare($sql);

        foreach ($row_to_insert as $key => $value) {
            $sth->bindValue(":{$key}", $value);
        }

        $sth->execute();
        return $this->pdo->lastInsertId();
    }

    public function delete(string $table, array $where = []): int {
        $sql = "DELETE FROM `{$table}`";
        list($whereClause, $params) = $this->where($where);

        if (!empty($whereClause)) {
            $sql .= " WHERE " . $whereClause;
        }

        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->rowCount();
    }

    public function update(string $table, array $row_to_update, array $where = []): int {
        $set_clauses = [];
        $update_params = [];

        foreach ($row_to_update as $key => $value) {
            $set_clauses[] = "`{$key}` = :update_{$key}";
            $update_params[":update_{$key}"] = $value;
        }

        $sql = "UPDATE `{$table}` SET " . implode(', ', $set_clauses);
        list($whereClause, $where_params) = $this->where($where);

        if (!empty($whereClause)) {
            $sql .= " WHERE " . $whereClause;
        }

        $params = array_merge($update_params, $where_params);

        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);

        $affectedRows = $sth->rowCount();
        return $affectedRows;
    }

    public function query(string $sql, array $params = []): array {
        try {
            $sth = $this->pdo->prepare($sql);
            $sth->execute($params);
            return $sth->fetchAll();
        } catch (PDOException $e) {
            error_log("DB_QUERY_ERROR: Database query error: " . $e->getMessage() . " - SQL: " . $sql);
            throw $e;
        }
    }
}
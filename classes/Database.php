<?php

namespace classes;

use PDO;

class Database {
    public ?PDO $pdo = null;
    public function __construct($host, $name, $user, $pass) {
        $this->pdo = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
    }


}
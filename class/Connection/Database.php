<?php

namespace Connection;

use PDO;

class Database {
    private $host = 'localhost';
    private $database = 'dbcomments';
    private $user = 'root';
    private $password = '';

    protected $connection;

    public function __construct() {
        $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->user, $this->password);
    }

    protected function getConnection() {
        return $this->connection;
    }
}
<?php

namespace Connection;

use PDO;

class Statements extends Database {
    private $fields;
    private $table;
    private $conditions;
    private $data;
    private $result;
    private $rows;

    public function getResult() {
        return $this->result;
    }
    
    public function getRows() {
        return $this->rows;
    }

    public function select($fields, $table, $conditions = null) {
        $connection = $this->getConnection();
        $this->fields = $fields;
        $this->table = $table;
        $this->conditions = $conditions;
        $query = "SELECT $this->fields FROM $this->table $this->conditions";
        
        $executeQuery = $connection->prepare($query);
        $executeQuery->execute();
        $this->result = $executeQuery->fetchAll(PDO::FETCH_ASSOC);
        $this->rows = $executeQuery->rowCount();
    }

    public function insert($table, $data) {
        $connection = $this->getConnection();
        $this->table = $table;
        $this->data = $data;
        $this->setFields();
        $query = "INSERT INTO $this->table ($this->fields) VALUES ($this->data)";
        
        $executeQuery = $connection->prepare($query);
        $executeQuery->execute();
        $this->result = $connection->lastInsertId();
    }

    public function delete($table, $conditions) {
        $connection = $this->getConnection();
        $this->table = $table;
        $this->conditions = $conditions;
        $query = "DELETE FROM $this->table $this->conditions";
        
        $executeQuery = $connection->prepare($query);
        $executeQuery->execute();
        $this->result = $executeQuery->rowCount();
    }

    public function update($table, $data, $conditions) {
        $connection = $this->getConnection();
        $this->table = $table;
        $this->data = $data;
        $this->conditions = $conditions;
        $this->setUpdateFields();
        $query = "UPDATE $this->table SET $this->fields $this->conditions";
        $executeQuery = $connection->prepare($query);
        $executeQuery->execute();
        $this->result = $executeQuery->rowCount();
    }

    private function setFields() {
        $this->fields = implode(', ', array_keys($this->data));
        $this->data = "'" . implode("', '", array_values($this->data)) . "'";        
    }

    private function setUpdateFields() {
        $this->fields = '';
        foreach ( $this->data as $key => $value) {
            $this->fields .= "$key = '$value', ";
        }
        $this->fields = trim($this->fields);
        $this->fields = rtrim($this->fields, ',');
    }
}
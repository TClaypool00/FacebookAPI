<?php
class BaseClass {
    protected $conn;
    protected $stmt;

    protected function __construct($db)
    {
        $this->conn = $db;
    }

    protected function stmt_executed() {
        if ($this->stmt->execute()) {
            return true;
        }

        printf('Error: %s \n', $this->stmt->error);

        return false;
    }

}
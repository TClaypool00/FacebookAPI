<?php
class User {
    private $conn;

    //Properties
    public $userId;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $isAdmin;

    //Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    //Get Users
    public function getAll() {
        $stmt = $this->conn->prepare('CALL getUsers();');

        $stmt->execute();

        return $stmt;
    }
}
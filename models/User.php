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
    
    public function get_single() {
        $stmt = $this->conn->prepare("CALL getSingleUser('{$this->userId}')");

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->first_name = $row['FirstName'];
        $this->last_name = $row['LastName'];
        $this->email = $row['Email'];
        $this->isAdmin = $row['IsAdmin'];
    }

    public function create() {
        $stmt = $this->conn->prepare("CALL insertUser('{$this->first_name}', '{$this->last_name}', '{$this->email}', '{$this->password}', '{$this->isAdmin}');");
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->isAdmin = htmlspecialchars(strip_tags($this->isAdmin));

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s \n', $stmt->error);

        return false;
    }
}
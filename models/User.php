<?php
class User {
    private $conn;
    private $options = [
        'cost' => 11
    ];

    //Properties
    public $userId;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $confirm_password;
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
        $this->clean_data();

        $this->password = $this->encrypt_password();

        $stmt = $this->conn->prepare("CALL insertUser('{$this->first_name}', '{$this->last_name}', '{$this->email}', '{$this->password}');");

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s \n', $stmt->error);

        return false;
    }

    public function update() {
        $this->clean_data();
        $stmt = $this->conn->prepare("CALL updateUser('{$this->first_name}', '{$this->last_name}', '{$this->email}', '{$this->password}', '{$this->isAdmin}', '{$this->userId}');");

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s \n', $stmt->error);

        return false;
    }

    public function password_confirm() {
        if ($this->password === $this->confirm_password) {
            return true;
        }

        return false;
    }

    public function password_meets() {
        if (preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $this->password)) {
            return true;
        }

        return false;
    }

    private function clean_data() {
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->isAdmin = htmlspecialchars(strip_tags($this->isAdmin));
    }

    private function encrypt_password() {
        return password_hash($this->password, PASSWORD_BCRYPT, $this->options);
    }
}
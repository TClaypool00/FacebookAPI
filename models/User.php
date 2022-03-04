<?php
class User extends BaseClass {
    private $options = [
        'cost' => 11
    ];

    //Properties
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
        $this->stmt = $this->prepare_stmt('CALL getUsers();');

        $this->stmt->execute();

        return $this->stmt;
    }
    
    public function get_single($show_password) {
        $this->stmt = $this->prepare_stmt("CALL getSingleUser('{$this->user_id}');");
        $this->stmt->execute();
        $this->row = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->user_first_name = $this->row_value('FirstName');
        $this->user_last_name = $this->row_value('LastName');
        $this->email = $this->row_value('Email');
        $this->isAdmin = $this->row_value('IsAdmin');

        if ($show_password) {
            $this->password = $this->row_value('Password');
        }
    }

    public function create() {
        $this->clean_data();

        $this->password = $this->encrypt_password();

        $this->stmt = $this->prepare_stmt("CALL insertUser('{$this->user_first_name}', '{$this->user_last_name}', '{$this->email}', '{$this->password}');");

        return $this->stmt_executed();
    }

    public function update() {
        $this->clean_data();
        $this->stmt = $this->prepare_stmt("CALL updateUser('{$this->user_first_name}', '{$this->user_last_name}', '{$this->email}', '{$this->isAdmin}', '{$this->userId}');");

        return $this->stmt_executed();
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
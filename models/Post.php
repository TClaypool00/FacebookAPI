<?php
class Post {
    private $conn;

    public $post_id;
    public $body;
    public $date_posted;
    public $user_id;

    public $user_firstname;
    public $user_lastname;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create() {
        $stmt = $this->conn->prepare("CALL insertPost('{$this->body}', '{$this->user_id}')");

        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s \n', $stmt->error);

        return false;
    }

    public function get_single() {
        $stmt = $this->conn->prepare("CALL getSinglePost('{$this->post_id}')");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->body = $row['Body'];
        $this->date_posted = $row['DatePosted'];
        $this->user_id = $row['UserId'];
        $this->user_firstname = $row['FirstName'];
        $this->user_lastname = $row['LastName'];
    }
}
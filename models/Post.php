<?php
class Post {
    private $conn;

    public $post_id;
    public $body;
    public $date_posted;
    public $user_id;

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
}
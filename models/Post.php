<?php
class Post extends BaseClass {
    public $post_id;
    public $body;
    public $date_posted;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create() {
        $this->clean_data();

        $this->stmt = $this->prepare_stmt("CALL insertPost('{$this->body}', '{$this->user_id}')");

        return $this->stmt_executed();
    }

    public function get_single() {
        $this->stmt = $this->prepare_stmt("CALL getSinglePost('{$this->post_id}')");
        $this->stmt->execute();

        $this->row = $this->stmt->fetch(PDO::FETCH_ASSOC);
        $this->body = $this->row_value('Body');
        $this->date_posted = $this->row_value('DatePosted');
        $this->user_id = $this->row_value('UserId');
        $this->user_firstname = $this->row_value('FirstName');
        $this->user_lastname = $this->row_value('LastName');
    }

    public function get_all() {
        $this->stmt = $this->prepare_stmt('CALL getAllPosts();');

        $this->stmt->execute();

        return $this->stmt;
    }

    public function update() {
        $this->clean_data();
        $this->stmt = $this->prepare_stmt("CALL updatePost('{$this->post_id}', '{$this->body}', '{$this->user_id}')");

        return $this->stmt_executed();
    }

    private function clean_data() {
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    }
}
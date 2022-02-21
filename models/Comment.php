<?php
class Comment extends BaseClass {
    public $comment_id;
    public $comment_body;
    public $date_posted;
    public $user_id;
    public $post_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create() {
        $this->stmt = $this->conn->prepare("CALL insComment('{$this->comment_body}', '{$this->user_id}', '{$this->post_id}');");
        $this->clean_data();

        return $this->stmt_executed();
    }

    private function clean_data() {
        $this->comment_body = htmlspecialchars(strip_tags($this->comment_body));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->post_id = htmlspecialchars(strip_tags($this->post_id));
    }
}
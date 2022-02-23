<?php
class Comment extends BaseClass {    
    public $comment_id;
    public $comment_body;
    public $date_posted;
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

    public function get_all($user_Checked, $post_Checked) {
        $this->select_query = 'SELECT * FROM view_comments';

        if ($user_Checked) {
            $this->select_query = $this->select_query . $this->and_where_query . ' UserId=' . $this->user_id;
        }

        if ($post_Checked) {
            $this->select_query = $this->select_query . $this->and_where_query . 'PostId=' . $this->post_id;
        }

        $this->stat = $this->prepare_stmt($this->select_query);
        $this->stat->execute();

        return $this->stat;
    }

    private function clean_data() {
        $this->comment_body = htmlspecialchars(strip_tags($this->comment_body));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->post_id = htmlspecialchars(strip_tags($this->post_id));
    }
}
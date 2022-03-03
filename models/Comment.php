<?php
class Comment extends BaseClass {    
    public $comment_id;
    public $comment_body;
    public $date_posted;
    public $post_id;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->select_query = 'SELECT * FROM view_comments';
    }

    public function create() {
        $this->stmt = $this->conn->prepare("CALL insComment('{$this->comment_body}', '{$this->user_id}', '{$this->post_id}');");
        $this->clean_data();

        return $this->stmt_executed();
    }

    public function get_all($user_Checked, $post_Checked) {
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

    public function get_single() {
        $this->stmt = $this->prepare_stmt($this->select_query . ' WHERE CommentId=' . $this->comment_id);

        $this->stmt->execute();

        $this->row = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->comment_body = $this->row_value('CommentBody');
        $this->date_posted = $this->row_value('DatePosted');
        $this->post_id = $this->row_value('PostId');
        $this->user_first_name = $this->row_value('FirstName');
        $this->user_last_name = $this->row_value('LastName');
    }

    private function clean_data() {
        $this->comment_body = htmlspecialchars(strip_tags($this->comment_body));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->post_id = htmlspecialchars(strip_tags($this->post_id));
    }
}
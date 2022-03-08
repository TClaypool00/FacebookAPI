<?php
class Reply extends BaseClass {
    public $reply_id;
    public $reply_body;
    public $date_posted;
    public $comment_id;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->select_query = 'SELECT * FROM view_replies';
    }

    public function create() {
        $this->clean_data();

        $this->stmt = $this->prepare_stmt("CALL insReply('{$this->reply_body}', '{$this->user_id}', '{$this->comment_id}');");

        return $this->stmt_executed();
    }

    public function get_all($comment_checked, $user_checked) {
        if ($comment_checked) {
            $this->additional_query = ' WHERE commentId = ' . $this->comment_id;
        }

        if ($user_checked) {
            if (!$this->is_additional_query()) {
                $this->additional_query = $this->additional_query . $this->and_where_query;
            } else {
                $this->additional_query = $this->additional_query . ' WHERE ';
            }

            $this->additional_query = $this->additional_query . 'userId = ' . $this->user_id;
        }

        $this->stmt = $this->prepare_stmt($this->select_query . $this->additional_query);

        $this->stmt->execute();

        return $this->stmt;
    }

    public function get_single() {
        $this->stmt = $this->prepare_stmt($this->select_query . ' WHERE replyId =' . $this->reply_id . ' ' . $this->limit);

        $this->stmt->execute();

        $this->row = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->reply_body = $this->row_value('ReplyBody');
        $this->date_posted = $this->row_value('DatePosted');
        $this->comment_id = $this->row_value('CommentId');
        $this->user_id = $this->row_value('UserId');
        $this->user_first_name = $this->row_value('FirstName');
        $this->user_last_name = $this->row_value('LastName');
    }

    public function update() {
        $this->clean_data();
        $this->stmt = $this->prepare_stmt("CALL updateReply('{$this->reply_body}', '{$this->reply_id}');");

        return $this->stmt_executed();
    }

    public function delete() {
        $this->stmt = $this->prepare_stmt("CALL deleteReply('{$this->reply_id}');");

        return $this->stmt_executed();
    }

    private function clean_data() {
        $this->reply_body = htmlspecialchars(strip_tags($this->reply_body));
        $this->comment_id = htmlspecialchars(strip_tags($this->comment_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    }
}
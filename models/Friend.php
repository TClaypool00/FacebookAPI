<?php
class Friend extends BaseClass {
    public $friend_id;
    public $sender_id;
    public $receiver_id;
    public $date_accepted;
    public $is_accepted;

    public $sender_frist_name;
    public $sender_last_name;

    public $receiver_first_name;
    public $receiver_last_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->select_query = 'SELECT * FROM view_friends ';
    }

    public function create() {
        $this->stmt = $this->prepare_stmt("CALL insertFriend('{$this->sender_id}', '{$this->receiver_id}');");
        $this->clean_data();

        return $this->stmt_executed();
    }

    public function get_all() {
        $this->stat = $this->prepare_stmt($this->select_query);

        $this->stmt->execute();

        return $this->stmt;
    }

    public function get_single() {
        if ($this->friend_id_null()) {
            $this->additional_query = 'WHERE SenderId=' . $this->sender_id . ' AND ReceiverId=' . $this->receiver_id;
        } else {
            $this->additional_query = 'WHERE FriendId=' . $this->friend_id;
        }

        $this->stat = $this->prepare_stmt($this->select_query . $this->additional_query);

        if ($this->friend_id_null() && ($this->get_row_count() == 0)) {
            $this->additional_query = 'WHERE ReceiverId=' . $this->sender_id . ' AND SenderId=' . $this->receiver_id;
            $this->stat->execute();
        }

        $this->stmt->execute();

        $this->row = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->sender_id = $this->row_value('SenderId');
        $this->sender_frist_name = $this->row_value('SenderFirstName');
        $this->sender_last_name = $this->row_value('SenderLastName');
        $this->receiver_id = $this->row_value('ReceiverId');
        $this->receiver_first_name = $this->row_value('ReceiverFirstName');
        $this->receiver_last_name = $this->row_value('ReceiverLastName');
        $this->is_accepted = $this->row_value('IsAccepted');
        $this->date_accepted = $this->row_value('DateAccepted');
    }

    public function accept() {
        $this->friend_id = htmlspecialchars(strip_tags($this->friend_id));
        $this->stmt = $this->conn->prepare("CALL acceptFriendRequest('{$this->friend_id}');");

        return $this->stmt_executed();
    }

    public function delete() {
        $this->stmt = $this->conn->prepare("CALL deleteFriendRequest('{$this->friend_id}');");
        $this->friend_id = htmlspecialchars(strip_tags($this->friend_id));

        return $this->stmt_executed();
    }

    private function friend_id_null() {
        if ($this->friend_id == null) {
            return true;
        }
        
        return false;
    }

    private function clean_data() {
        $this->sender_id = htmlspecialchars(strip_tags($this->sender_id));
        $this->receiver_id = htmlspecialchars(strip_tags($this->receiver_id));
    }
}
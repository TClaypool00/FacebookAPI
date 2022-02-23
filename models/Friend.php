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
        $this->stmt = $this->conn->prepare("CALL insertFriend('{$this->sender_id}', '{$this->receiver_id}');");
        $this->sender_id = htmlspecialchars(strip_tags($this->sender_id));
        $this->receiver_id = htmlspecialchars(strip_tags($this->receiver_id));

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

        $this->stmt->execute();

        if ($this->friend_id_null() && ($this->get_row_count() == 0)) {
            $this->additional_query = 'WHERE ReceiverId=' . $this->sender_id . ' AND SenderId=' . $this->receiver_id;
            $this->stat->execute();
        }

        $row = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->sender_id = $row['SenderId'];
        $this->sender_frist_name = $row['SenderFirstName'];
        $this->sender_last_name = $row['SenderLastName'];
        $this->receiver_id = $row['ReceiverId'];
        $this->receiver_first_name = $row['ReceiverFirstName'];
        $this->receiver_last_name = $row['ReceiverLastName'];
        $this->is_accepted = $row['IsAccepted'];
        $this->date_accepted = $row['DateAccepted'];
    }

    public function accept() {
        $this->stmt = $this->conn->prepare("CALL acceptFriendRequest('{$this->friend_id}');");
        $this->friend_id = htmlspecialchars(strip_tags($this->friend_id));

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
}
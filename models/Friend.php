<?php
class Friend {
    private $conn;
    private $get_all_query = 'SELECT * FROM view_friends';
    private $additional_query = '';
    private $and_query = ' AND ';

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
    }

    public function create() {
        $stmt = $this->conn->prepare("CALL insertFriend('{$this->sender_id}', '{$this->receiver_id}');");
        $this->sender_id = htmlspecialchars(strip_tags($this->sender_id));
        $this->receiver_id = htmlspecialchars(strip_tags($this->receiver_id));

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s \n', $stmt->error);

        return false;
    }

    public function get_all() {
        if (get_isset('receiverId')) {
            $this->additional_query += 'WHERE ReceiverId =' . $this->receiver_id;
        }

        if (get_isset(('senderId'))) {
            if ($this->is_string_default()) {
                $this->additional_query = $this->additional_query . $this->and_query;
            }
            $this->additional_query = $this->additional_query . ' WHERE SenderId =' . $this->sender_id;
        }

        if (get_isset('isAccpted')) {
            if ($this->is_string_default()) {
                $this->additional_query += $this->and_query;
            }
            $this->get_all_query = $this->get_all_query . ' WHERE IsAccpted =' . $this->is_accepted;
            
        }

        if (get_isset('dateAccpted')) {
            if ($this->is_string_default()) {
                $this->additional_query += $this->and_query;
            }
            $this->get_all_query = $this->get_all_query . ' WHERE DateAccpted =' . $this->date_accepted;
        }

        $stmt = $this->conn->prepare($this->get_all_query . $this->additional_query);

        $stmt->execute();

        return $stmt;

    }

    private function is_string_default() {
        if ($this->additional_query != '') {
            return true;
        }

        return false;
    }
}
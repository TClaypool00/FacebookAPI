<?php
class Friend {
    private $conn;

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
        if (!$this->number_is_numeric($this->sender_id)) {
            echo 'Sender Id has to be a number';
            die();
        }

        if (!$this->number_is_numeric($this->receiver_id)) {
            echo 'Receiver Id Id has to be a number';
            die();
        }

        $stmt = $this->conn->prepare("CALL insertFriend('{$this->sender_id}', '{$this->receiver_id}');");
        $this->sender_id = htmlspecialchars(strip_tags($this->sender_id));
        $this->receiver_id = htmlspecialchars(strip_tags($this->receiver_id));

        if ($stmt->execute()) {
            return true;
        }

        printf('Error: %s \n', $stmt->error);

        return false;
    }

    private function number_is_numeric($id) {
        if (is_numeric($id)) {
            return true;
        }

        return false;
    }
}
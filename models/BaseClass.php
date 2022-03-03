<?php
class BaseClass {
    protected $and_where_query = ' AND WHERE ';
    protected $conn;
    protected $stmt;
    protected $select_query;
    protected $additional_query;
    protected $limit = ' LIMIT 0, 1';
    protected $row;

    public $user_id;
    public $user_first_name;
    public $user_last_name;

    public function get_row_count() {
        return $this->stat->rowcount();
    }

    protected function stmt_executed() {
        if ($this->stmt->execute()) {
            return true;
        }

        printf('Error: %s \n', $this->stmt->error);

        return false;
    }

    protected function prepare_stmt($statement) {
        return $this->conn->prepare($statement);
    }

    protected function row_value($value) {
        return $this->row[$value];
    }
}
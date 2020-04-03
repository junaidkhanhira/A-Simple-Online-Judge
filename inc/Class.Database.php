<?php
class Database {
    private $conn;
    private $error;

    public function open_conn() {
        $this->conn = new mysqli("localhost", "root", "", "oj_1");

        if ($this->conn->connect_errno) {
            echo "Failed to connect to Database: " . $this->conn->connect_error;
            die();
        }
        
        return $this->conn;
    }

    public function close_conn() {
        $this->conn->close();
    }

    public function show_error() {
        $this->error = $this->conn->error;
        return $this->error;
    }

    public function run_query($query) {
        $result = $this->conn->query($query);
        return $result;
    }
}
?>  
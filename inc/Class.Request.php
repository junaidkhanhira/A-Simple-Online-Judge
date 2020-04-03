<?php

include_once("Class.Database.php");

class Request {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function get_request_data($req_id) {
        $this->db->open_conn();
        $query = "SELECT * FROM ps_requests WHERE req_id='$req_id'";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
        return $result;
    }

    public function get_all_pending_req() {
        $this->db->open_conn();
        $query = "SELECT * FROM ps_requests WHERE req_status='pending' ORDER BY req_date DESC";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
        return $result;
    }

    public function update_pending_req($req_id, $req_status) {
        $this->db->open_conn();

        $query1 = "SELECT * FROM ps_requests WHERE req_id=$req_id";
        $result = $this->db->run_query($query1);
        $req_data = $result->fetch_array(MYSQLI_ASSOC);
        $sender_id = $req_data['sender_id'];

        $query2 = "UPDATE users SET user_level='problem_setter' WHERE user_id='$sender_id'";
        $this->db->run_query($query2);

        $query3 = "UPDATE ps_requests SET req_status='$req_status' WHERE req_id='$req_id'";
        $result = $this->db->run_query($query3);

        $this->db->close_conn();
        return $result;
    }
}
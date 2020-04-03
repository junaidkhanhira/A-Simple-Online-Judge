<?php

include_once("Class.Database.php");

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function reg_user($name, $email, $password) {
        $conn = $this->db->open_conn();

        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $password = md5($password);

        
        $query1 = "SELECT * FROM users WHERE email='$email'";
        $check =  $this->db->run_query($query1);

        if ($check->num_rows == 0) {
            $uniq_dir = uniqid();
            $query2 = "INSERT INTO users SET uniq_dir='$uniq_dir', name='$name', email='$email', password='$password', user_level='problem_solver', submission_count=0, solve_count=0";
            $result = $this->db->run_query($query2);
            $this->db->close_conn();
            return $result;
        }
        else {
            $this->db->close_conn();
            return false;
        }
    }

    public function check_login($email, $password) {
        $this->db->open_conn();

        $password = md5($password);
        $query = "SELECT user_id from users WHERE email='$email' AND password='$password'";

        $result = $this->db->run_query($query);
        $userData = $result->fetch_array(MYSQLI_ASSOC);

        if ($result->num_rows == 1) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $userData['user_id'];
            $this->db->close_conn();
            return true;
        }
        else{
            $this->db->close_conn();
            return false;
        }
    }

    public function get_user_data($user_id){
        $this->db->open_conn();

        $query = "SELECT * FROM users WHERE user_id='$user_id'";
        $result = $this->db->run_query($query);
        if ($result->num_rows == 1) {
            $userData = $result->fetch_array(MYSQLI_ASSOC);
            $this->db->close_conn();
            return $userData;
        } else {
            $this->db->close_conn();
            return false;
        }
    }

    public function get_session(){
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        } else {
            return false;
        }
    }

    public function user_logout() {
        $_SESSION['login'] = false;
        session_destroy();
    }

    public function get_all_users() {
        $this->db->open_conn();
        $query = "SELECT * FROM users ORDER BY registration_date DESC";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
        return $result;
    }

    public function get_all_submissions($user_id) {
        $this->db->open_conn();
        $query = "SELECT * FROM submissions WHERE user_id='$user_id'  ORDER BY sub_date DESC";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
        return $result;
    }

    public function send_ps_request($user_id, $ps_message) {
        $conn = $this->db->open_conn();
        $ps_message = $conn->real_escape_string($ps_message);

        $query = "INSERT INTO ps_requests SET sender_id='$user_id', message='$ps_message', req_status='pending'";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
        return $result;
    }

    public function change_user_level($user_id, $user_level) {
        $this->db->open_conn();
        $query = "UPDATE users SET user_level='$user_level' WHERE user_id='$user_id'";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
    }

    public function update_user_submission_count($user_id) {
        $this->db->open_conn();

        $query = "UPDATE users SET submission_count=submission_count+1 WHERE user_id='$user_id'";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
    }

    public function update_user_solve_count($user_id, $prob_id) {
        $this->db->open_conn();

        $query1 = "SELECT * FROM submissions WHERE user_id='$user_id' AND prob_id='$prob_id' AND sub_status='AC'";
        $result = $this->db->run_query($query1);
        
        if ($result->num_rows <= 1) {
            $query2 = "UPDATE users SET solve_count=solve_count+1 WHERE user_id='$user_id'";
            $this->db->run_query($query2);
        }

        $this->db->close_conn();
    }
    

}
    
?>
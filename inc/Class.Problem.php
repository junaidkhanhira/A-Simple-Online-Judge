<?php

include_once("Class.Database.php");

class Problem {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function add_problem($prob_setter_id, $prob_title, $prob_statement, $input_format, $output_format,
                                $sample_input, $sample_output, $prob_input, $prob_output, $difficulty) {
        $conn = $this->db->open_conn();

        $uniq_dir = uniqid();
        $prob_title = $conn->real_escape_string($prob_title);
        $prob_statement = $conn->real_escape_string($prob_statement);
        $input_format = $conn->real_escape_string($input_format);
        $output_format = $conn->real_escape_string($output_format);
        $sample_input = $conn->real_escape_string($sample_input);
        $sample_output = $conn->real_escape_string($sample_output);
        $difficulty = $conn->real_escape_string($difficulty);

        $query = "INSERT INTO problems SET prob_setter_id=$prob_setter_id, uniq_dir='$uniq_dir', prob_title='$prob_title', prob_statement='$prob_statement',
                  input_format='$input_format', output_format='$output_format', sample_input='$sample_input', sample_output='$sample_output',
                  submission_count=0, solve_count=0, difficulty=$difficulty";
        $result = $this->db->run_query($query);

        if ($result) {
            $dir_path = "problem/" . $uniq_dir;
            mkdir($dir_path);
            $inp_file = fopen($dir_path . "/input.txt", "w");
            $out_file = fopen($dir_path . "/output.txt", "w");
            fwrite($inp_file, $prob_input);
            fwrite($out_file, $prob_output);
            fclose($inp_file);
            fclose($out_file);
            $this->db->close_conn();
            return true;
        } else {
            $this->db->close_conn();
            return false;
        }
    }

    public function get_problem($prob_id) {
        $this->db->open_conn();

        $query = "SELECT * FROM problems WHERE prob_id='$prob_id'";
        $result = $this->db->run_query($query);
        if ($result->num_rows == 1) {
            $problemData = $result->fetch_array(MYSQLI_ASSOC);
            $this->db->close_conn();
            return $problemData;
        } else {
            $this->db->close_conn();
            return false;
        }
    }

    public function get_all_problems() {
        $this->db->open_conn();

        $query = "SELECT * FROM problems ORDER BY add_date DESC";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
        return $result;
    }

    public function update_prob_submission_count($prob_id) {
        $this->db->open_conn();

        $query = "UPDATE problems SET submission_count=submission_count+1 WHERE prob_id='$prob_id'";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
        return $result;
    }

    public function update_prob_solve_count($prob_id) {
        $this->db->open_conn();

        $query = "UPDATE problems SET solve_count=solve_count+1 WHERE prob_id='$prob_id'";
        $result = $this->db->run_query($query);
        $this->db->close_conn();
        return $result;
    }
}

?>
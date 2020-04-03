<?php

include_once("Class.Database.php");
include_once("Class.Problem.php");

class Submission {
    private $db;
    private $sub_status;

    public function __construct() {
        $this->db = new Database();
    }

    public function get_sub_status() {
        return $this->sub_status;
    }

    public function execute_code($code, $prob_uniq_dir) {
		$uniq_file_name = uniqid();

        $code_file = "$uniq_file_name.c";
        $input_file_name = "problem/$prob_uniq_dir/input.txt";
		$output_file_name = "problem/$prob_uniq_dir/output.txt";
		$user_output_file_name = "$uniq_file_name.txt";

		
		$file = fopen($code_file, "w");
		fwrite($file, $code);
		fclose($file);

		exec("gcc -o $uniq_file_name $code_file", $out1, $ret1); // compiling the solution

		if ($ret1 == 0) {
			exec("$uniq_file_name < $input_file_name > $user_output_file_name", $out2, $ret2); // executing the solution

			if ($ret2 == 0) {
				$f1 = file_get_contents($output_file_name); // returns a string
				$f2 = file_get_contents($user_output_file_name); // returns a string
				$fda1 = explode("\n", $f1);
				$fda2 = explode("\n", $f2);

				$this->sub_status = "AC";
				if (count($fda1) == count($fda2)) {
					$len = count($fda1);
					for ($i = 0; $i < $len; $i++) {
						if ($fda1[$i] != $fda2[$i]) { // check file content mismatch
							$this->sub_status = "WA";
							break;
						}
					}
				} else {
					$this->sub_status = "WA";
				}
			} else {
				$this->sub_status = "RTE";
			}
		} else {
			$this->sub_status = "CE";
		}

		$file_pattern = "$uniq_file_name.*";
		array_map("unlink", glob($file_pattern));
		
        return $this->sub_status;
    }

    public function save_submission($code, $prob_id, $user_id) {
        $conn = $this->db->open_conn();

        $query = "INSERT INTO submissions SET prob_id='$prob_id', user_id='$user_id', code='$code', sub_status='$this->sub_status'";
        $result = $this->db->run_query($query);

        return $result;
	}
	
	
}

?>
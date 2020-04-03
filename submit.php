<?php
include_once('inc/header.php');
include_once("inc/Class.User.php");
include_once("inc/Class.Problem.php");
include_once("inc/Class.Submission.php");

$user = new User();
$problem = new Problem();
$submission = new Submission();

if ($user->get_session()) {
	$user_id = $_SESSION['user_id'];
	$user_data = $user->get_user_data($user_id);
	$user_uniq_dir = $user_data["uniq_dir"];
} else {
    header("location: login.php");
}

if (isset($_GET["prob_id"])) {
	$prob_id = $_GET["prob_id"];
	$prob_data = $problem->get_problem($prob_id);
	$prob_uniq_dir = $prob_data["uniq_dir"];
} else {
	header("location: index.php");
}

if (isset($_POST["problem_solution"])) {
	$code = $_POST["problem_solution"];
	$submission->execute_code($code, $prob_uniq_dir);
	$submission->save_submission($code, $prob_id, $user_id);
	$problem->update_prob_submission_count($prob_id);
	$user->update_user_submission_count($user_id);
} else {
	header("location: index.php");
}

if ($submission->get_sub_status() == "AC") {
	$sub_status_msg = "Accepted!";
	$sub_status_icon = "icon-emo-laugh";
	$problem->update_prob_solve_count($prob_id);
	$user->update_user_solve_count($user_id, $prob_id);
} else if (($submission->get_sub_status() == "WA")) {
	$sub_status_msg = "Wrong Answer!";
	$sub_status_icon = "icon-cancel";
} else if (($submission->get_sub_status() == "RTE")) {
	$sub_status_msg = "Runtime Error!";
	$sub_status_icon = "icon-cancel";
} else {
	$sub_status_msg = "Compilation Error!";
	$sub_status_icon = "icon-cancel";
}

?>



<div class="container">
    <div class="submission-status-section white-bg shadow-bg">
        <h1><span class="<?php echo "$sub_status_icon"; ?>"></span></h1>
        <div class="section-content">
			
			<?php echo "<h4>$sub_status_msg</h4>"; ?>

        </div>
    </div>
</div>


<?php include('inc/footer.php'); ?>
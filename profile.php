<?php
include_once('inc/header.php');
include_once("inc/Class.User.php");
include_once("inc/Class.Problem.php");

$user = new User();
$problem = new Problem();

if (isset($_GET['user_id'])) {
    if($user->get_session()) {
        $logged_in = true;
    } else {
        $logged_in = false;
    }
    $user_id = $_GET['user_id'];
    $user_data = $user->get_user_data($user_id);
    if ($user_data) {
        $name = $user_data["name"];
        $email = $user_data["email"];
        $user_level = "";
        $submission_count = $user_data["submission_count"];
        $solve_count = $user_data["solve_count"];
    }
} else if($user->get_session()) {
    $logged_in = true;
    $user_id = $_SESSION['user_id'];
    $user_data = $user->get_user_data($user_id);
    if($user_data) {
        $name = $user_data["name"];
        $email = $user_data["email"];
        $user_level = $user_data["user_level"];
        $submission_count = $user_data["submission_count"];
        $solve_count = $user_data["solve_count"];
    }
} else {
    header("location: login.php");
}

$all_submissions = $user->get_all_submissions($user_id);

?>

<div class="container">
    <div class="profile-section white-bg shadow-bg">
        <?php if (!$user_data): ?>
            <div class="section-content">
                <h3 class="section-msg">User does not exist!</h3>
            </div>
        <?php else: ?>
            <div class="section-content">
                <div class="profile-img">
                    <img src="img/me.jpg" alt="">
                </div>

                <div class="profile-info">
                    <p class="profile-name"><?php echo $name; ?></p>
                    <p class="profile-username"><?php echo $email; ?></p>
                </div>

                <div id="profile-stat" class="profile-stat">
                    <ul>
                        <li><span><?php echo $submission_count; ?></span><br>Submissions</li>
                        <li><span><?php echo $solve_count; ?></span><br>Problems Solved</li>
                    </ul>
                </div>

                <div class="profile-submission-history">
                    <?php if ($submission_count > 0): ?>
                        <table class="submission-history-table">
                            <caption>Submission History</caption>
                            <thead>
                                <tr>
                                    <th>Problem Title</th>
                                    <th>Status</th>
                                    <th>Submitted By</th>
                                    <th>Submission Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    
                                    foreach($all_submissions as $single_submission) {
                                        $prob_data = $problem->get_problem($single_submission["prob_id"]);
                                        $user_data = $user->get_user_data($single_submission["user_id"]);

                                        $sub_status_title = ["AC" => "Accepted", "WA" => "Wrong Answer", "CE" => "Compilation Error", "RTE" => "Runtime Error"];
                                        
                                        echo "<tr>";
                                        echo "<td><a href=\"problem.php?prob_id=". $single_submission["prob_id"] ."\">". $prob_data['prob_title'] ."</a></td>";
                                        echo "<td style=\"font-size:12px;font-weight:500;\">". $sub_status_title[$single_submission['sub_status']] ."</td>";
                                        echo "<td><a  style=\"color:#f26950;\" href=\"profile.php?user_id=". $user_data['user_id'] ."\">". $user_data['name'] ."</a></td>";
                                        echo "<td>". substr($single_submission['sub_date'], 0, 10) ."</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    <?php else: echo "<h3 class=\"empty-msg\">No Submission History</h3>"; ?>
                    <?php endif; ?>
                </div>

                <?php if ($logged_in && $user_level == "problem_solver"): ?>
                    <div class="ps-request-btn">
                        <a class="btn btn-lg" href="ps-request.php">Request To Be A Problem Setter</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
        
<?php include('inc/footer.php'); ?>

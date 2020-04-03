<?php
include_once('inc/header.php');
include_once('inc/Class.Problem.php');
include_once("inc/Class.User.php");
include_once("inc/Class.Request.php");

$user = new User();
$problem = new Problem();
$ps_request = new Request();


if ($user->get_session()) {
    $user_id = $_SESSION['user_id'];
    $user_data = $user->get_user_data($user_id);
    if ($user_data['user_level'] != "admin") {
        header("location: index.php");
    }
} else {
    header("location: login.php");
}


$all_pen_requests = $ps_request->get_all_pending_req();
$all_problems = $problem->get_all_problems();
$all_users = $user->get_all_users();

?>

<div class="container">
    <div class="admin-section-tab white-bg shadow-bg br-10">
        <div id="admin-section-tab-nav" class="admin-section-tab-nav">
            <a id="tab-nav-1" class="tab-nav active" data-tab="tab-content-1" href="#" onClick="adminTab(this.id)">Requests</a>
            <a id="tab-nav-2" class="tab-nav" data-tab="tab-content-2" href="#" onClick="adminTab(this.id)">Users</a>
            <a id="tab-nav-3" class="tab-nav" data-tab="tab-content-3" href="#" onClick="adminTab(this.id)">Problems</a>
        </div>
        <div id="admin-section-tab-content" class="admin-section-tab-content">
            <div class="tab-content active" id="tab-content-1">
                <?php if ($all_pen_requests->num_rows > 0): ?>
                    <table class="ps-request-table">
                        <thead>
                            <tr>
                                <th>Sent By</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            
                                foreach($all_pen_requests as $single_request) {
                                    $user_data = $user->get_user_data($single_request["sender_id"]);
                                    
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<img src=\"img/user_img/".$user_data['uniq_dir']."/pro_pic.jpg\" alt=\"\">";
                                    echo "<a href=\"profile.php?user_id?=". $single_request['sender_id'] ."\">". $user_data['name'] ."</a>";
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<a class=\"req-msg\" href=\"read-request.php?req_id=". $single_request['req_id'] ."\">". substr($single_request['message'], 0, 50) ."...</a>";
                                    echo "</td>";
                                    echo "<td>". substr($single_request['req_date'], 0, 10) ."</td>";
                                    echo "</tr>";
                                }
                            
                            ?>
                            
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="section-msg">No Requests</div>
                <?php endif; ?>
            </div>
            <div class="tab-content" id="tab-content-2">
            <?php if ($all_users->num_rows > 0): ?>
                    <table class="ps-request-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Level</th>
                                <th>Submission Count</th>
                                <th>Solve Count</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            
                                foreach($all_users as $single_user) {
                                    $user_level = [
                                                    "problem_solver" => "Problem Solver",
                                                    "problem_setter_pending" => "Problem Solver",
                                                    "problem_setter" => "Problem Setter",
                                                    "admin" => "Admin"
                                    ];
                                    
                                    echo "<tr>";
                                    echo "<td><a href=\"profile.php?user_id=". $single_user['user_id'] ."\">". $single_user['name'] ."</a></td>";
                                    echo "<td>". $single_user['email'] ."</td>";
                                    echo "<td>". $user_level[$single_user['user_level']] ."</td>";
                                    echo "<td>". $single_user['submission_count'] ."</td>";
                                    echo "<td>". $single_user['solve_count'] ."</td>";
                                    echo "<td>". substr($single_user['registration_date'], 0, 10) ."</td>";
                                    echo "</tr>";
                                }
                            
                            ?>
                            
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="section-msg">No Requests</div>
                <?php endif; ?>
            </div>
            <div class="tab-content" id="tab-content-3">
                <?php if($all_problems->num_rows > 0): ?>
                    <table class="problems-table">
                        <thead>
                            <tr>
                                <th>Problem Title</th>
                                <th>Difficulty</th>
                                <th>Submissions</th>
                                <th>Acceptance Rate</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                foreach($all_problems as $single_problem) {
                                    if ($single_problem['solve_count'] == 0) {
                                        $acceptance_rate = 0;
                                    } else {
                                        $acceptance_rate = ceil(($single_problem['solve_count'] / $single_problem['submission_count'])*100);
                                    }

                                    $difficulty_array = ["", "Basic", "Easy", "Advanced", "Hard", "Expert"];
                                    
                                    echo "<tr>";
                                    echo "<td><a href=\"problem.php?prob_id=". $single_problem['prob_id'] ."\">". $single_problem['prob_title'] ."</a></td>";
                                    echo "<td><span class=\"problem-difficulty\">". $difficulty_array[$single_problem['difficulty']] ."</span></td>";
                                    echo "<td>". $single_problem['submission_count'] ."</td>";
                                    echo "<td>";
                                    echo "<span class=\"problem-success-bar\"><i data-percentage=\"". $acceptance_rate ."\"></i></span>";
                                    echo "<span class=\"problem-success-percent\">". $acceptance_rate ."%</span>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                            
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="section-msg">0 Problems Found</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('inc/footer.php'); ?>

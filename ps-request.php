<?php
include_once('inc/header.php');
include_once("inc/Class.User.php");

$user = new User();

if ($user->get_session()) {
    $admin_flag = false;
    $prob_sett_flag = false;
    $prob_sol_flag = false;
    $ps_pending_flag = false;
    $user_id = $_SESSION['user_id'];
    $user_data = $user->get_user_data($user_id);
    if($user_data) {
        $user_level = $user_data["user_level"];
        if ($user_level == "admin") {
            $admin_flag = true;
        }
        if ($user_level == "problem_setter") {
            $prob_sett_flag = true;
        }
        if ($user_level == "problem_setter_pending") {
            $ps_pending_flag = true;
        }
        if ($user_level == "problem_solver") {
            $prob_sol_flag = true;
        }
        if ($prob_sol_flag) {
            if (isset($_POST['ps-submit-btn'])) {
                $ps_message = trim($_POST["ps-message"]);
                $send_request = $user->send_ps_request($user_id, $ps_message);
                $user->change_user_level($user_id, "problem_setter_pending");
                if ($send_request) {
                    $ps_pending_flag = true;
                }
            }
        }
    }
} else {
    header("location: login.php");
}

?>


<div class="container">
    <div class="ps-request-section white-bg shadow-bg">
        <?php if ($prob_sol_flag) echo "<h1>Become A Problem Setter</h1>"; ?>
        <div class="section-content">
            <?php
                if($admin_flag) {
                    echo "<p class=\"section-msg\">You are already an admin!!!</p>";
                }
        
                if ($prob_sett_flag) {
                    echo "<p class=\"section-msg\">You are already a problem setter.</p>";
                }
        
                if ($ps_pending_flag) {
                    echo "<p class=\"section-msg\">Your request is sent. Please, wait.</p>";
                }
            ?>

            <?php if ($prob_sol_flag && !$ps_pending_flag): ?>
                <form id="ps-request-form" action="ps-request.php" method="post" autocomplete="off" onsubmit="return psMessageValidation()">
                    <div>
                        <textarea id="ps-message" type="text" name="ps-message" placeholder="Message"></textarea>
                        <span id="ps-message-error"></span>
                    </div>

                    <div style="text-align:center;">
                        <input class="btn btn-lg" type="submit" name="ps-submit-btn" value="Send Request">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
        
<?php include('inc/footer.php'); ?>

<?php
include_once('inc/header.php');
include_once('inc/Class.User.php');

$user = new User();
$active_class = "";

if ($user->get_session()) {
    $user_id = $_SESSION['user_id'];
	header("location: profile.php?user_id=" . $user_id);
}

if (isset($_POST["r-submit-btn"])) {
    $rName = trim($_POST["r-name"]);
    $rEmail = trim($_POST["r-email"]);
    $rPassword = trim($_POST["r-password"]);

    $register = $user->reg_user($rName, $rEmail, $rPassword);
    if ($register) {
        header("location: login.php");
    } else {
        $active_class = "active";
        $status_message = "Email Already Exists";
    }
}

include_once('inc/toast.php');

?>


<div class="container">
    <div class="register-section white-bg shadow-bg">
        <h1>Sign Up</h1>
        <div class="section-content">
            <form id="register-user-form" action="register.php" method="post" autocomplete="off" onsubmit="return registerUserValidation()">
                <div>
                    <input id="r-name" type="text" name="r-name" placeholder="Name">
                    <span id="r-name-error"></span>
                </div>

                <div>
                    <input id="r-email" type="text" name="r-email" placeholder="Email">
                    <span id="r-email-error">Email address invalid</span>
                </div>

                <div>
                    <input id="r-password" type="password" name="r-password" placeholder="Password">
                    <span id="r-password-error">Password is too short</span>
                </div>

                <div>
                    <input id="r-cpassword" type="text" name="r-cpassword" placeholder="Confirm Password">
                    <span id="r-cpassword-error">Password didn't match</span>
                </div>

                <input class="btn btn-lg" type="submit" name="r-submit-btn" value="Sign Up">
            </form>
        </div>
    </div>
</div>
        
<?php include('inc/footer.php'); ?>

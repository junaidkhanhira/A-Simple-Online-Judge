<?php
include_once('inc/header.php');
include_once('inc/Class.User.php');

$user = new User();
$active_class = "";

if (isset($_POST['l-submit-btn'])) {
    $l_email = trim($_POST["l-email"]);
    $l_password = trim($_POST["l-password"]);
    $login = $user->check_login($l_email, $l_password);
    if ($login) {
        header("location:profile.php");
    } else {
        $active_class = "active";
        $status_message = "Invalid Email/Password";
    }
}

include_once('inc/toast.php');

?>


<div class="container">
    <div class="login-section white-bg shadow-bg">
        <h1>Login</h1>
        <div class="section-content">
            <form id="login-user-form" action="login.php" method="post" autocomplete="off" onsubmit="return loginUserValidation()">
                <div>
                    <input id="l-email" type="text" name="l-email" placeholder="Email">
                    <span id="l-email-error"></span>
                </div>

                <div>
                    <input id="l-password" type="password" name="l-password" placeholder="Password">
                    <span id="l-password-error"></span>
                </div>

                <input class="btn btn-lg" type="submit" name="l-submit-btn" value="Login">
            </form>
        </div>
    </div>
</div>
        
<?php include('inc/footer.php'); ?>

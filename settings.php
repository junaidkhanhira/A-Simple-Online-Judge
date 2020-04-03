<?php
include_once('inc/header.php');
include_once("inc/Class.User.php");

$user = new User();

if ($user->get_session()) {
    $user_id = $_SESSION['user_id'];
    $userData = $user->get_user_data($user_id);
    if($userData) {
        
    } else {
        echo "Cannot retrive data";
    }
} else {
    header("location:login.php");
}

?>

<div class="container">
    <div class="settings-section white-bg shadow-bg br-10">
        <h1 class="center-align">Update Info</h1>
        <div class="section-content">
            <form id="settings-form" class="add-problem-form" action="" method="post" autocomplete="off" onsubmit="return addProblemValidation()">

                <div>
                    <p>Name</p>
                    <input id="settings-name" type="text" name="settings-name" value="Name">
                    <span id="settings-name-error"></span>
                </div>

                <div>
                    <p>Email</p>
                    <input id="settings-email" type="text" name="settings-email" value="Email">
                    <span id="settings-email-error"></span>
                </div>

                <div>
                    <p>Phone Number</p>
                    <input id="settings-phone" type="text" name="settings-phone" value="">
                    <span id="settings-phone-error"></span>
                </div>

                <input class="btn btn-lg" type="submit" name="s-submit-btn" value="Save Settings">
            </form>
        </div>
    </div>
</div>
        
<?php include('inc/footer.php'); ?>

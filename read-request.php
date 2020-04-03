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
    } else {
        if(isset($_GET['req_id'])) {
            $req_id = $_GET['req_id'];
            if(isset($_GET['ac'])) {
                if ($_GET['ac'] == 'y') {
                    $req_accepted = true;
                    $ps_request->update_pending_req($req_id, "accepted");
                    header("location: admin.php");
                } else {
                    $req_accepted = false;
                    $ps_request->update_pending_req($req_id, "rejected");
                    header("location: admin.php");
                }
            } else {
                $request_result = $ps_request->get_request_data($req_id);
                $request_data = $request_result->fetch_array(MYSQLI_ASSOC);
                $sender_data = $user->get_user_data($request_data['sender_id']);
            }

            
        } else {
            header("location: admin.php");
        }
    }
}

?>

<div class="container">
    <div class="read-request-section white-bg shadow-bg">
        <div class="section-content">
            <h3>Sent By: <a href="profile.php?user_id?="><?php echo $sender_data['name']; ?></a></h3>
            <p><?php echo nl2br($request_data['message']); ?></p>
            <a class="btn btn-sm" href="read-request.php?req_id=<?php echo $req_id; ?>&ac=y">Accept</a>
            <a class="btn btn-sm" href="read-request.php?req_id=<?php echo $req_id; ?>&ac=n">Reject</a>
        </div>
    </div>
</div>
        
<?php include('inc/footer.php'); ?>
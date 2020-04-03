<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_NOTICE);

include_once("inc/Class.User.php");

$user = new User();

if ($user->get_session()) {
    $id = $_SESSION['user_id'];
    $userData = $user->get_user_data($id);

    $userNavBtn = "<img src=\"img/me.jpg\" alt=\"\">";
    $userNavMenu = "<li><a href=\"profile.php\">Profile</a></li>";
    if ($userData['user_level'] == "admin" || $userData['user_level'] == "problem_setter") {
        $userNavMenu .= "<li><a href=\"add-problem.php\">Add Problem</a></li>";
    }
    if ($userData['user_level'] == "admin") {
        $userNavMenu .= "<li><a href=\"admin.php\">Dashboard</a></li>";
    }
    $userNavMenu .= "<li><a href=\"logout.php?q=logout\">Log Out</a></li>";
} else {
    $userNavBtn = "<span class=\"icon-menu\"></span>";
    $userNavMenu = "
        <li><a href=\"login.php\">Login</a></li>
        <li><a href=\"register.php\">Register</a></li>
    ";
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Problem</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:400,500,700&display=swap" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/fontello.css">
        <link type="text/css" rel="stylesheet" media="all" href="css/style.css">
	</head>
	<body>
        <div class="top-bar">
            <div class="site-logo">
                <img src="img/logo.png" alt="">
            </div>
            <div class="site-nav">
                <nav class="main-nav">
                    <ul>
                        <li><a class="btn" href="index.php">All Problems</a></li>
                    </ul>
                    <div class="user-nav">
                        <div id="user-nav-btn" class="user-nav-btn">
                            <?php echo $userNavBtn; ?>
                        </div>
                        <div id="user-nav-menu" class="user-nav-menu shadow-bg br-5">
                            <ul>
                                <?php echo $userNavMenu; ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
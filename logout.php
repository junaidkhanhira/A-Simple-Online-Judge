<?php
session_start();

include_once("inc/Class.User.php");

$user = new User();

if (!$user->get_session()){
    header("location:login.php");
}

if (isset($_GET['q'])){
    if ($_GET['q'] == 'logout') {
        $user->user_logout();
        header("location:login.php");
    }
}

?>
<?php

// to do:
//     - change user_id to logged in user id

require_once('../connect.php'); 
session_start();
$userid = $_SESSION['user-id'];

run_mysql_query("DELETE FROM followings WHERE followings.user_id = " . $_POST['id'] . " AND follower_id = $userid"); 
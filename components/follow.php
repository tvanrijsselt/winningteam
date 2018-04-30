<?php
// to do:
//     - change user_id to logged in user id

require_once('../connect.php'); 
session_start();
$userid = $_SESSION['user-id'];

run_mysql_query("INSERT INTO followings (followings.user_id, follower_id) VALUES ({$_POST['userid']}, $userid)");
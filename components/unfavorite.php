<?php

// to do:
//     - change user_id to logged in user id

require_once('../connect.php'); 
session_start();
$userid = $_SESSION['user-id'];

run_mysql_query("DELETE FROM faves WHERE faves.tweet_id = " . $_POST['id'] . " AND faves.user_id = $userid"); 
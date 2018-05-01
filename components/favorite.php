<?php

// to do:
//     - change user_id to logged in user id

require_once('../connect.php'); 
include_once('../queries.php');
session_start();
$userid = $_SESSION['user-id'];

if (!fetch_record($check_faves . $_POST['id'])) {
    run_mysql_query("INSERT INTO faves (tweet_id, faves.user_id) VALUES ({$_POST['id']}, $userid)");
}
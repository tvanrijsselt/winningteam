<?php

// to do:
//     - change user_id to logged in user id

require_once('../connect.php'); 
include_once('../queries.php');

if (!fetch_record($check_faves . $_POST['id'])) {
    run_mysql_query('INSERT INTO faves (tweet_id, user_id) VALUES (' . $_POST['id'] .', 1)');
}
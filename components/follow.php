<?php
// to do:
//     - change user_id to logged in user id

require_once('../connect.php'); 

run_mysql_query('INSERT INTO followings (user_id, follower_id) VALUES (' . $_POST['userid'] . ', 1)');
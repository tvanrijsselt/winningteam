<?php

// to do:
//     - change user_id to logged in user id

require_once('../connect.php'); 

run_mysql_query('DELETE FROM followings WHERE user_id =' . $_POST['id'] . ' AND follower_id = 1'); 
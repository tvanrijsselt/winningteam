<?php

// to do:
//     - change user_id to logged in user id

require_once('../connect.php'); 

run_mysql_query('DELETE FROM faves WHERE tweet_id =' . $_POST['id'] . ' AND user_id=1'); 
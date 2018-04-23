<?php

// to do:
//     - delete id value, because faves.id should be set to auto increment

require_once('../connect.php'); 

run_mysql_query('INSERT INTO faves (tweet_id, users_id, id) VALUES (' . $_POST['id'] .', 1, 2)');
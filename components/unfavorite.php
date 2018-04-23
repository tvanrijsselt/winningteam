<?php

require_once('../connect.php'); 

run_mysql_query('DELETE FROM faves WHERE tweet_id =' . $_POST['id']);
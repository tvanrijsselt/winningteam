<?php

  require_once('../connect.php');
  session_start();

  if(isset($_POST['action']) && $_POST['action'] == 'delete-tweet') {
    $query = "DELETE FROM tweets WHERE tweets.id = '{$_POST['tweet']}'";
    header("Location: ./account.php");

    run_mysql_query($query);
  }

 ?>

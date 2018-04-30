<?php
require_once('../connect.php');

$content = $_POST['content'];
$picture = $_POST['picture'];
$user_id = 1; //change to logged in userid
$tweet_id = $_POST['tweet_id'];

if ($content != '' OR $picture != '') {
    run_mysql_query("INSERT INTO replies (content, picture, user_id, tweet_id) 
                 VALUES ('{$content}', '{$picture}', '{$user_id}', '{$tweet_id}')");
}

header("Location: feed.php");
<?php
require_once('../connect.php');
session_start();
$userid = $_SESSION['user-id'];

$content = $_POST['content'];
$picture = $_POST['picture'];
$userid = $_SESSION['user-id']; //change to logged in userid
$tweet_id = $_POST['tweet_id'];

$content = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['content']))));
$picture = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['picture']))));

if ($content != '' OR $picture != '') {
    run_mysql_query("INSERT INTO replies (content, picture, user_id, tweet_id, created_at) 
                 VALUES ('{$content}', '{$picture}', '{$userid}', '{$tweet_id}', now())");
}

header("Location: feed.php");
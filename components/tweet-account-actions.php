<?php

  require_once('../connect.php');
  session_start();

  $username = $_SESSION['username'];
  $password = $_SESSION['password'];
  $userid = $_SESSION['user-id'];

  // if(isset($_POST['action']) && $_POST['action'] == 'delete-tweet') {
  //   $query = "DELETE FROM tweets WHERE tweets.id = '{$_POST['tweet']}'";
  //   header("Location: ./account.php");
  //
  //   run_mysql_query($query);
  // }

  if(!empty($_POST['delete-tweets'])) {
    function delete_multiple_tweets() {
      foreach($_POST['tweet'] as $tweet) {
        $query = "DELETE FROM tweets WHERE tweets.id = $tweet";
        run_mysql_query($query);

        if(run_mysql_query($query))
        {
            $_SESSION['message-success'] = "Tweet(s) has/have been deleted correctly!";
        }
        else
        {
            $_SESSION['message-fail'] = "Tweet(s) has/have been deleted correctly!";
        }
      }
    }

    delete_multiple_tweets();
    header("Location: ./account.php");
  }

  if(isset($_POST['action']) && $_POST['action'] == 'edit_tweet_hidden') {

    $errors = array();

    if(count($errors) > 0) {

      $_SESSION['errors'] = $errors;
      header('Location: ./account.php');
    } else {
      $_SESSION['errors'] = array();

      if(!empty($_POST['edit_tweet_submit'])) {

        if(empty($_POST['edit_tweet-photo'])) {
          $query = "UPDATE tweets SET tweet = '{$_POST['edit_tweet']}' WHERE tweets.id = {$_POST['tweet_id']}";

          run_mysql_query($query);
          header('Location: ./account.php');

        } else {
          $query = "UPDATE tweets SET picture = '{$_POST['edit_tweet-photo']}' WHERE tweets.id = {$_POST['tweet_id']}";

          $query2 = "UPDATE tweets SET tweet = '{$_POST['edit_tweet']}' WHERE tweets.id = {$_POST['tweet_id']}";

          run_mysql_query($query);
          run_mysql_query($query2);

          header('Location: ./account.php');
        }
      }
    }
  }

  if(isset($_POST['action']) && $_POST['action'] == 'post_tweet') {

    if(!empty($_POST['post_tweet_submit'])) {

      if(empty($_POST['tweet'])) {
        header('Location: ./account.php');
      } else {
        $query = "INSERT INTO tweets (user_id, tweet, picture) VALUES ('$userid','{$_POST['tweet']}', '{$_POST['photo']}')";

        run_mysql_query($query);
        header('Location: ./account.php');
      }
    }
  }

  // Edit photo //
  if(!empty($_POST['edit_photo_submit'])) {

    if(empty($_POST['new_photo'])) {
      header("Location: ./account.php");
    } else {
      $query = "UPDATE users SET profile_pic = '{$_POST['new_photo']}' WHERE users.id = $userid";

      mysqli_query($connection, $query);
      header("Location: ./account.php");
    }

  }

 ?>

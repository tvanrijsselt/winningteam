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

  // Edit a tweet.
  if(isset($_POST['action']) && $_POST['action'] == 'edit_tweet_hidden') {

    $editTweetPhoto = $_POST['edit_tweet-photo'];
    $editTweetText = $_POST['edit_tweet'];

    if(!empty($_POST['edit_tweet_submit'])) {
      if(empty($editTweetText) && empty($editTweetPhoto)) {
        header("Location: ./account.php");
      }
      elseif(empty($editTweetPhoto) && !empty($editTweetText)) {
        $query = "UPDATE tweets SET tweet = '$editTweetText' WHERE tweets.id = {$_POST['tweet_id']}";

        run_mysql_query($query);
        header("Location: ./account.php");
      }
      elseif(empty($editTweetText) && !empty($editTweetPhoto)) {
        $query = "UPDATE tweets SET picture = '$editTweetPhoto' WHERE tweets.id = {$_POST['tweet_id']}";

        run_mysql_query($query);
        header("Location: ./account.php");
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

  //post tweet from feed
  if(isset($_POST['action']) && $_POST['action'] == 'post_tweet_feed') {

    if(!empty($_POST['post_tweet_submit'])) {

      if(empty($_POST['tweet'])) {
        header('Location: ./feed.php');
      } else {
        $query = "INSERT INTO tweets (user_id, tweet, picture) VALUES ('$userid','{$_POST['tweet']}', '{$_POST['photo']}')";

        run_mysql_query($query);
        header('Location: ./feed.php');
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

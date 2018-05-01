<?php

  require_once('../connect.php');
  session_start();

  $username = $_SESSION['username'];
  $password = $_SESSION['password'];
  $userid = $_SESSION['user-id'];

  // ----- TWEET ACTIONS ----- //
  // ------------------------- //

  // Delete tweets in the account page. 
  if(!empty($_POST['delete-tweets'])) {
    function delete_multiple_tweets() {
      foreach($_POST['tweet'] as $tweet) {
        $query = "DELETE FROM tweets WHERE tweets.id = $tweet";
        run_mysql_query($query);
        $_SESSION['message-success-tweet'] = "Tweet(s) has/have been deleted correctly!";
      }
    }

    delete_multiple_tweets();
    header("Location: ./account.php");
  }

  // Edit a tweet in the account page.
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
        $_SESSION['message-success-tweet'] = "Tweet text has been edited correctly!";
        header("Location: ./account.php");
      }
      elseif(empty($editTweetText) && !empty($editTweetPhoto)) {
        $query = "UPDATE tweets SET picture = '$editTweetPhoto' WHERE tweets.id = {$_POST['tweet_id']}";

        run_mysql_query($query);
        $_SESSION['message-success-tweet'] = "Tweet photo has been edited correctly!";
        header("Location: ./account.php");
      }
      else {
        $query = "UPDATE tweets SET picture = '$editTweetPhoto' WHERE tweets.id = {$_POST['tweet_id']}";
        run_mysql_query($query);

        $query2 = "UPDATE tweets SET tweet = '$editTweetText' WHERE tweets.id = {$_POST['tweet_id']}";
        run_mysql_query($query2);

        $_SESSION['message-success-tweet'] = "Tweet has been edited correctly!";
        header("Location: ./account.php");
      }
    }
  }

  // post tweet from account
  // if(isset($_POST['action']) && $_POST['action'] == 'post_tweet') {

  //   if(!empty($_POST['post_tweet_submit'])) {

  //     if(empty($_POST['tweet'])) {
  //       header('Location: ./account.php');
  //     } else {
  //       $query = "INSERT INTO tweets (user_id, tweet, picture) VALUES ('$userid','{$_POST['tweet']}', '{$_POST['photo']}')";

  //       run_mysql_query($query);
  //       header('Location: ./account.php');
  //     }
  //   }
  // }

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

    $newphoto = $_POST['new_photo'];

    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $newphoto)) {
      $errors[] = "URL is not valid.";
    } else {
      if(empty($_POST['new_photo'])) {
        header("Location: ./account.php");
      } else {
        $query = "UPDATE users SET profile_pic = '{$_POST['new_photo']}' WHERE users.id = $userid";
  
        mysqli_query($connection, $query);
        $_SESSION['message-success'] = "Your photo has been updated correctly!";
        header("Location: ./account.php");
      }
    }
  }

  // ----- ACCOUNT DETAILS ACTIONS ----- //
  // ---------------------------------- //
  //---- process for changing the first name ----//
  if(isset($_POST['action']) && $_POST['action'] == 'firstname') {

      if(empty($_POST['firstname'])) {
        $errors[] = "Your name cannot be blank.";
      }

      if (!preg_match("/^[a-zA-Z ]*$/", $_POST['firstname'])) {
        $errors[] = "Only letters and white space allowed for your name.";
      }

      if(count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: account.php");
      } elseif ($_POST['firstname'] !== $currentFirstName){
        $_SESSION['errors'] = array();

        $query = "UPDATE users SET firstname = '{$_POST['firstname']}' WHERE id = $userid";

        mysqli_query($connection, $query);
        $_SESSION['message-success'] = "Your first name has been updated correctly!";
        header("Location: account.php");
      }
  }
  //---- end of process for changing the first name ----//

  // ---- process for changing the last name ----//
  if(isset($_POST['action']) && $_POST['action'] == 'lastname') {
    // check if the first name field is empty
    if(empty($_POST['lastname'])) {
      $errors[] = "The field for updating your last name cannot be blank.";
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $_POST['lastname'])) {
      $errors[] = "Only letters and white space allowed for your name";
    }

    if(count($errors) > 0) {
      $_SESSION['errors'] = $errors;
      header("Location: account.php");
    } else {
      $_SESSION['errors'] = array();

      $query = "UPDATE users SET lastname = '{$_POST['lastname']}' WHERE id = $userid";

      mysqli_query($connection, $query);
      $_SESSION['message-success'] = "Your last name has been updated correctly!";
      header("Location: account.php");
    }
  }
  //---- end of process for changing the last name ----//

  //---- process for changing the email ----//
  if(isset($_POST['action']) && $_POST['action'] == 'email') {
    $email = $_POST['email'];

    if(empty($email)) {
      $errors[] = "Email field cannot be blank.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Email is not valid.";
    }

    if(count($errors) > 0) {
      $_SESSION['errors'] = $errors;
      header("Location: ./account.php");
    } else {
      $_SESSION['errors'] = array();

      $email = htmlspecialchars(strip_tags(trim($email)));

      $query = "UPDATE users SET email = '$email' WHERE id = $userid";

      mysqli_query($connection, $query);
      $_SESSION['message-success'] = "Your email has been updated correctly!";
      header("Location: account.php");
    }
  }
  //---- end of process for changing the email ----//

  //---- process for changing the biography ----//
  if(isset($_POST['action']) && $_POST['action'] == 'bio') {

    $bio = $_POST['biography'];

    // if(empty($bio)) {
    //   $bio = fetch_record("SELECT bio FROM users WHERE username = '$username'")['bio'];
    // }

    $query = "UPDATE users SET bio = '$bio' WHERE id = $userid";

    if(mysqli_query($connection, $query)) {
      $_SESSION['message-success'] = "Your bio has been updated correctly!";
      header("Location: account.php");
    } else {
      $_SESSION['message-fail'] = "Your bio has not been updated correctly!";
      header("Location: account.php");
    }
  }
  //---- end of process for changing the biography ----//

  //---- process for changing the country ----//
  if(isset($_POST['action']) && $_POST['action'] == 'country') {
    $country = escape_this_string($_POST['country']);

    // $country = htmlspecialchars(strip_tags(trim($country)));

    $query = "UPDATE users SET country = '$country' WHERE id = $userid";

    if(mysqli_query($connection, $query))
    {
      $_SESSION['message-success'] = "Country has been updated correctly!";
      header("Location: account.php");
    }
    else
    {
      $_SESSION['message-fail'] = "Failed to update country..";
      header("Location: account.php");
    }
  }
  //---- end of process for changing the country ----//

  //---- process for changing the birthdate ----//
  if(isset($_POST['action']) && $_POST['action'] == 'birthdate') {
    $birthdate = $_POST['birthdate'];

    // if(empty($birthdate)) {
    //   fetch_record("SELECT birthdate FROM users WHERE username = '$username'")['birthdate'];
    // }

    $query = "UPDATE users SET birthdate = '$birthdate' WHERE id = $userid";

    if(mysqli_query($connection, $query))
    {
      $_SESSION['message-success'] = "Your birthdate has been updated correctly!";
      header("Location: account.php");
    }
    else
    {
      $_SESSION['message-fail'] = "Failed to update birthdate..";
      header("Location: account.php");
    }
  }
//---- end of process for changing the birthdate ----//

 ?>

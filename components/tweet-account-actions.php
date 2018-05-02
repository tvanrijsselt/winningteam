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

    // $editTweetPhoto = $_POST['edit_tweet-photo'];
    $editTweetPhoto = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['edit_tweet-photo']))));
    // $editTweetText = $_POST['edit_tweet'];
    $editTweetText = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['edit_tweet']))));

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

        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $editTweetPhoto)) {
          $_SESSION['message-fail-tweet'] = "URL is not valid.";
          header("Location: ./account.php");
        } else {
          $query = "UPDATE tweets SET picture = '$editTweetPhoto' WHERE tweets.id = {$_POST['tweet_id']}";

          run_mysql_query($query);
          $_SESSION['message-success-tweet'] = "Tweet photo has been edited correctly!";
          header("Location: ./account.php");
        }
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
  // this code is such as mess :(
  if(isset($_POST['action']) && $_POST['action'] == 'post_tweet') {

    if(!empty($_POST['post_tweet_submit'])) {
      $postTweet = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['tweet']))));
      $postTweetPhoto = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['photo']))));

      // if both input fields for the tweet are empty, redirect to the account page
      if(empty($postTweet) && empty($postTweetPhoto)) {
        $_SESSION['message-fail-post'] = "How lonely is the sound of a silent bird.";
        header("Location: ./account.php");
      } 
      if(empty($postTweet) && !empty($postTweetPhoto)) {
        // if the text input is empty but the photo is not, then just post the photo 

        // check the url validity of the photo
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $postTweetPhoto)) {
            $_SESSION['message-fail-post'] = "URL is not valid.";
            header("Location: ./account.php");
          } else {
            // if the url of the photo is valid, insert the photo
            $query = "INSERT INTO tweets (user_id, picture, created_at) VALUES ('$userid', '$postTweetPhoto', now())";

            run_mysql_query($query);
            header('Location: ./feed.php');
          }
      } 
      // if the text tweet input is not empty but the photo input is, just post the tweet
      if(empty($postTweetPhoto) && !empty($postTweet)) {
        $query = "INSERT INTO tweets (user_id, tweet, created_at) VALUES ('$userid','$postTweet', now())";

        run_mysql_query($query);
        header('Location: ./feed.php');
      }
      if(!empty($postTweet) && !empty($postTweetPhoto))
      {
        // if the text tweet input is not empty and the photo input is also not empty, check if the url is valid
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $postTweetPhoto)) {
          $_SESSION['message-fail-post'] = "URL is not valid.";
          header("Location: ./account.php");
        } else {
          // if the url of the photo is valid, insert both the photo and the text
          $query = "INSERT INTO tweets (user_id, tweet, picture, created_at) VALUES ('$userid','$postTweet', '$postTweetPhoto', now())";

          run_mysql_query($query);
          header('Location: ./feed.php');
        }
      }
    }
  }

  // post tweet from feed
  // this code is such as mess :(
  if(isset($_POST['action']) && $_POST['action'] == 'post_tweet_feed') {

    if(!empty($_POST['post_tweet_submit'])) {
      $postTweetFeed = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['tweet']))));
      $postPhotoFeed = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['photo']))));

      // if both input fields for the tweet are empty, redirect to the account page
      if(empty($postTweetFeed) && empty($postPhotoFeed)) {
        $_SESSION['message-fail-post'] = "How lonely is the sound of a silent bird.";
        header("Location: ./feed.php");
      } 
      if(empty($postTweetFeed) && !empty($postPhotoFeed)) {
        // if the text input is empty but the photo is not, then just post the photo 

        // check the url validity of the photo
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $postPhotoFeed)) {
            $_SESSION['message-fail-post'] = "URL is not valid.";
            header("Location: ./feed.php");
          } else {
            // if the url of the photo is valid, insert the photo
            $query = "INSERT INTO tweets (user_id, picture, created_at) VALUES ('$userid', '$postPhotoFeed', now())";

            run_mysql_query($query);
            header('Location: ./feed.php');
          }
      } 
      // if the text tweet input is not empty but the photo input is, just post the tweet
      if(empty($postPhotoFeed) && !empty($postTweetFeed)) {
        $query = "INSERT INTO tweets (user_id, tweet, created_at) VALUES ('$userid','$postTweetFeed', now())";

        run_mysql_query($query);
        header('Location: ./feed.php');
      }
      if(!empty($postTweetFeed) && !empty($postPhotoFeed))
      {
        // if the text tweet input is not empty and the photo input is also not empty, check if the url is valid
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $postPhotoFeed)) {
          $_SESSION['message-fail-post'] = "URL is not valid.";
          header("Location: ./feed.php");
        } else {
          // if the url of the photo is valid, insert both the photo and the text
          $query = "INSERT INTO tweets (user_id, tweet, picture, created_at) VALUES ('$userid','$postTweetFeed', '$postPhotoFeed', now())";

          run_mysql_query($query);
          header('Location: ./feed.php');
        }
      }
    }
  }

  // Edit photo //
  if(!empty($_POST['edit_photo_submit'])) {

    // $newphoto = $_POST['new_photo'];
    $newphoto = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['new_photo']))));

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

      $newFirstName = escape_this_string(htmlspecialchars(strip_tags(trim(ucfirst($_POST['firstname'])))));

      if(empty($newFirstName)) {
        $errors[] = "Your name cannot be blank.";
      }

      if (!preg_match("/^[a-zA-Z ]*$/", $newFirstName)) {
        $errors[] = "Only letters and white space allowed for your name.";
      }

      if(count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: account.php");
      } elseif ($newFirstName !== $currentFirstName){
        $_SESSION['errors'] = array();

        $query = "UPDATE users SET firstname = '$newFirstName' WHERE id = $userid";

        mysqli_query($connection, $query);
        $_SESSION['message-success'] = "Your first name has been updated correctly!";
        header("Location: account.php");
      }
  }
  //---- end of process for changing the first name ----//

  // ---- process for changing the last name ----//
  if(isset($_POST['action']) && $_POST['action'] == 'lastname') {

    $newLastName = escape_this_string(htmlspecialchars(strip_tags(trim(ucfirst($_POST['lastname'])))));

    // check if the first name field is empty
    if(empty($newLastName)) {
      $errors[] = "The field for updating your last name cannot be blank.";
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $newLastName)) {
      $errors[] = "Only letters and white space allowed for your name";
    }

    if(count($errors) > 0) {
      $_SESSION['errors'] = $errors;
      header("Location: account.php");
    } else {
      $_SESSION['errors'] = array();

      $query = "UPDATE users SET lastname = '$newLastName' WHERE id = $userid";

      mysqli_query($connection, $query);
      $_SESSION['message-success'] = "Your last name has been updated correctly!";
      header("Location: account.php");
    }
  }
  //---- end of process for changing the last name ----//

  //---- process for changing the email ----//
  if(isset($_POST['action']) && $_POST['action'] == 'email') {

    $email = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['email']))));
    // $email = $_POST['email'];

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

    $bio = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['biography']))));
    // $bio = $_POST['biography'];

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

    $country = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['country']))));

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

<?php

  require_once('../connect.php');
  session_start();

  $username = $_SESSION['username'];
  $password = $_SESSION['password'];
  $userid = $_SESSION['user-id'];

  if(isset($_POST['action']) && $_POST['action'] == 'password') {
    $password = escape_this_string($_POST['current-password']);
    $userPassword = fetch_record("SELECT password FROM users WHERE username = '$username'")['password'];
    $newPassword = $_POST['new-password'];

    if(password_verify($password, $userPassword)) {
      if(empty($_POST['new-password'])) {
        $errors[] = "The field for updating a password cannot be empty.";
      }

      if(count($errors) > 0) {
        $_SESSION['errors-pass'] = $errors;
        header("Location: account.php");
      } else {
        $encrypted_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $_SESSION['errors-pass'] = array();

        // $password = escape_this_string($_POST['current-password']);
        $queryPass = "UPDATE users SET password = '$encrypted_password' WHERE users.id = $userid";

        if(run_mysql_query($queryPass))
        {
          $_SESSION['message-password'] = "Password has been updated correctly!";
          header("Location: account.php");
        }
        else
        {
          $_SESSION['message-password'] = "Password has been updated correctly!";
          header("Location: account.php");
        }
      }
    }
    else {
      $errors[] = "Your password is not correct.";

      if(count($errors) > 0) {
        $_SESSION['errors-pass'] = $errors;
        header("Location: account.php");
      }
    }
  }

  ?>

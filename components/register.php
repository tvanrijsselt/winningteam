<?php

  require_once('../connect.php');
  session_start();

  $firstNameError = "First Name";
  $lastNameError = "Last Name";
  $emailError = "Email";
  $usernameError = "Username";
  $passError = "Password";
  $passCheckError = "Confirm password";

  // check if the user is already logged in, then redirect straight to account. otherwise stay on the register page.
  if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    header("Location: feed.php");
  }

  // $firstname = $_POST['firstname'];
  // $lastname = $_POST['lastname'];
  // $username = $_POST['username'];
  // $email = $_POST['email'];
  // $password = $_POST['password'];

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty($_POST['firstname'])) {
      $firstNameError = "First name is required.";
    } if (!preg_match("/^[a-zA-Z ]*$/", $_POST['firstname'])) {
      $firstNameError = "Only letters and white space allowed";
    } else {
      // remove all HTML & PHP tags from a string and remove unneccesary characters
      // convert special characters to HTML entities to prevent attackers from exploiting the code by injecting HTML or JS code in forms with htmlspecialchars
      $firstname = escape_this_string(htmlspecialchars(strip_tags(trim(ucfirst($_POST['firstname'])))));
    }

    if(empty($_POST['lastname'])) {
      $lastNameError = "Last name is required.";
    } if (!preg_match("/^[a-zA-Z ]*$/", $_POST['lastname'])) {
      $lastNameError = "Only letters and white space allowed";
    } else {
      $lastname = escape_this_string(htmlspecialchars(strip_tags(trim(ucfirst($_POST['lastname'])))));
    }

    if(empty($_POST['username'])) {
      $usernameError = "Username is required.";
    }
    elseif (strlen($_POST['username']) < 5) {
      $usernameError = "Username is too short.";
    }
    else {
      // Check if the username already exists.
      $query = "SELECT * FROM users WHERE username = '{$_POST['username']}'";
      $userCheck = fetch_record($query);

      if($userCheck) {
        $usernameError = "User already exists, try a new name.";
      } else {
        $username = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['username']))));
      }
    }

    if(empty($_POST['email'])) {
      $emailError = "Email is required.";
      $passError = "Password is required.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $emailError = "Email is not valid.";
    } else {
      if(empty($_POST['password'])) {
        $passError = "Password is required.";
      } else {
        if($_POST['password'] != $_POST['passwordCheck']) {
          $passCheckError = "Passwords do not match.";
        } else {
          $encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

          $email = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['email']))));

          $query = "INSERT INTO users (firstname, lastname, username, email, password) VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$encrypted_password}')";

          if(run_mysql_query($query)) {
            $_SESSION['register-message'] = "Registration successful!";
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $userid = fetch_record("SELECT id FROM users WHERE username = '$username'")['id'];
            $_SESSION['user-id'] = $userid;
            header("Location: ./feed.php");
          } else {
            $_SESSION['register-message'] = "Failed to register. Try again!";
          }
        }
      }
    }
  }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Twitter</title>
    <link rel="stylesheet" href="./styles/register.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" rel="stylesheet">
  </head>
  <body>

    <div class="container">
      <!-- Registration form -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <br>
            <h3>Register</h3>
            <p><?php echo $_SESSION['register-message']; ?></p>
            <!-- // reset the registration message on refresh -->
            <?php $_SESSION['register-message'] = ""; ?>
            <br>
            <!-- to ensure that the values are not erased when a user makes a mistake, echo the user's input in the value attribute -->
            <!-- <label for="firstname" class="font-weight-bold register-input-label">First Name</label> -->
            <input type="text" name="firstname" placeholder="<?php echo $firstNameError ?>" value="<?php echo $firstname; ?>" class="register-input" maxlength="50" autofocus>
            <br>
            <!-- <label for="lastname" class="font-weight-bold register-input-label">Last Name</label> -->
            <input type="text" name="lastname" placeholder="<?php echo $lastNameError ?>" value="<?php echo $lastname; ?>" class="register-input" maxlength="50">
            <br>
            <!-- <label for="username" class="font-weight-bold register-input-label">Username</label> -->
            <input type="text" name="username" placeholder="<?php echo $usernameError ?>" value="<?php echo $username; ?>" class="register-input" maxlength="15">
            <br>
            <!-- <label for="email" class="font-weight-bold register-input-label">Email</label> -->
            <input type="text" name="email" placeholder="<?php echo $emailError ?>" value="<?php echo $_POST['email']; ?>" class="register-input">
            <br>
            <!-- <label for="password" class="font-weight-bold register-input-label">Password</label> -->
            <input type="password" name="password" placeholder="<?php echo $passError ?>" value="" class="register-input">
            <br>
            <!-- <label for="passwordCheck" class="font-weight-bold register-input-label">Password repeat</label> -->
            <input type="password" name="passwordCheck" placeholder="<?php echo $passCheckError ?>" value="" class="register-input">
            <br><br>
            <input type="submit" name="register-user-submit" class="btn btn-light" value="Register">
            <p>Already have an account? <a href="./login.php">Log In</a>.</p>
      </form>
    </div>
  </body>
</html>

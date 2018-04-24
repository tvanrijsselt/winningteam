<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Twitter</title>
    <?php

      require_once('../connect.php');
      session_start();

      if($_SERVER["REQUEST_METHOD"] == "POST") {

        $firstname = escape_this_string($_POST['firstname']);
        $lastname = escape_this_string($_POST['lastname']);
        $username = escape_this_string($_POST['username']);
        $email = escape_this_string($_POST['email']);
        $password = escape_this_string($_POST['password']);

        if(empty($firstname)) {
          $firstNameError = "First name is required.";
        } if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
          $firstNameError = "Only letters and white space allowed";
        } else {
          // remove all HTML & PHP tags from a string and remove unneccesary characters
          // convert special characters to HTML entities to prevent attackers from exploiting the code by injecting HTML or JS code in forms with htmlspecialchars
          $firstname = htmlspecialchars(strip_tags(trim(ucfirst($firstname))));
        }

        if(empty($lastname)) {
          $lastNameError = "Last name is required.";
        } if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
          $lastNameError = "Only letters and white space allowed";
        } else {
          $lastname = htmlspecialchars(strip_tags(trim(ucfirst($lastname))));
        }

        if (empty($username)) {
          $usernameError = "Username is required.";
        } elseif (strlen($username) < 5) {
          $usernameError = "Username is too short.";
        } else {
          // Check if the username already exists.
          $query = "SELECT * FROM users WHERE username = '$username'";
          $userCheck = fetch_record($query);

          if($userCheck) {
            $usernameError = "User already exists, try a new name please.";
          } else {
            $username = htmlspecialchars(strip_tags(trim($username)));
          }
        }

        if(empty($email)) {
          $emailError = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailError = "Email is not valid.";
        } else {
          $email = htmlspecialchars(strip_tags(trim($email)));
        }

        if(empty($password)) {
          $passError = "Password is required.";
        } else {
          $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
        }

        $query = "INSERT INTO users (firstname, lastname, username, email, password) VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$encrypted_password}')";

        if(run_mysql_query($query)) {
          $_SESSION['username'] = $username;
          $_SESSION['password'] = $password;
          $_SESSION['register-message'] = "Registration successful!";
          $firstname = "";
          $lastname = "";
          $username = "";
          $email = "";
        } else {
          $_SESSION['register-message'] = "Failed to register. Try again!";
        }
      }

     ?>
  </head>
  <body>

    <!-- Registration form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group row justify-content-center">
        <div class="col">
          <br>
          Register
          <br><br>
          <!-- to ensure that the values are not erased when a user makes a mistake, echo the user's input in the value attribute -->
          <label for="firstname" class="font-weight-bold register-input-label">First Name</label>
          <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="register-input" maxlength="50" autofocus> <span>* <?php echo $firstNameError; ?></span>
          <br>
          <label for="lastname" class="font-weight-bold register-input-label">Last Name</label>
          <input type="text" name="lastname" value="<?php echo $lastname ?>" class="register-input" maxlength="50"> <span>* <?php echo $lastNameError; ?></span>
          <br>
          <label for="username" class="font-weight-bold register-input-label">Username</label>
          <input type="text" name="username" value="<?php echo $username ?>" class="register-input" maxlength="15"> <span>* <?php echo $usernameError; ?></span>
          <br>
          <label for="email" class="font-weight-bold register-input-label">Email</label>
          <input type="email" name="email" value="<?php echo $email ?>" class="register-input"> <span>* <?php echo $emailError; ?></span>
          <br>
          <label for="password" class="font-weight-bold register-input-label">Password</label>
          <input type="password" name="password" value="" class="register-input"> <span>* <?php echo $passError; ?></span>
          <br><br>
          <input type="submit" name="register-user-submit" class="btn btn-light" value="Register">
          <br><br>
          <?php

          echo $_SESSION['register-message'];
          // reset the registration message on refresh
          $_SESSION['register-message'] = "";

          ?>
        </div>
      </div>
    </form>
  </body>
</html>

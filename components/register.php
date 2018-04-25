<?php

  require_once('../connect.php');
  session_start();

  // check if the user is already logged in, then redirect straight to account. otherwise stay on the register page.
  if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    header("Location: account.php");
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
        $usernameError = "User already exists, try a new name please.";
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
          $passError = "Passwords do not match.";
        } else {
          $encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

          $email = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['email']))));
        }
      }
    }

  // To-do: if the query fails then a new user id is generated anyway. correct this by nesting this query and all the other if statements.
  $query = "INSERT INTO users (firstname, lastname, username, email, password) VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$encrypted_password}')";

  if(run_mysql_query($query)) {
    // $_SESSION['register-message'] = "Registration successful!";
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    require_once('login.php');
    // $firstname = "";
    // $lastname = "";
    // $username = "";
    // $email = "";
  } else {
    $_SESSION['register-message'] = "Failed to register. Try again!";
  }
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Twitter</title>
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
          <input type="text" name="firstname" value="<?php echo $_POST['firstname']; ?>" class="register-input" maxlength="50" autofocus> <span>* <?php echo $firstNameError; ?></span>
          <br>
          <label for="lastname" class="font-weight-bold register-input-label">Last Name</label>
          <input type="text" name="lastname" value="<?php echo $_POST['lastname']; ?>" class="register-input" maxlength="50"> <span>* <?php echo $lastNameError; ?></span>
          <br>
          <label for="username" class="font-weight-bold register-input-label">Username</label>
          <input type="text" name="username" value="<?php echo $_POST['username']; ?>" class="register-input" maxlength="15"> <span>* <?php echo $usernameError; ?></span>
          <br>
          <label for="email" class="font-weight-bold register-input-label">Email</label>
          <input type="text" name="email" value="<?php echo $_POST['email']; ?>" class="register-input"> <span>* <?php echo $emailError; ?></span>
          <br>
          <label for="password" class="font-weight-bold register-input-label">Password</label>
          <input type="password" name="password" value="" class="register-input"> <span>* <?php echo $passError; ?></span>
          <br>
          <label for="passwordCheck" class="font-weight-bold register-input-label">Password repeat</label>
          <input type="password" name="passwordCheck" value="" class="register-input">
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

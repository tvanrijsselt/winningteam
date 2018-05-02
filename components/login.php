<?php

  require_once('../connect.php');
  session_start();

  $usernameError = "Username";
  $passError = "Password";

  // check if a user is logged in, if so redirect straight to account. otherwise show the login page as normal
  if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $userid = $_SESSION['user-id'];
    header("Location: account.php");
  }

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty($_POST['username'])) {
      $usernameError = "Username is required.";
    } else {
      // check if username is correct
      $query = "SELECT * FROM users WHERE username = '{$_POST['username']}'";
      $userCheck = fetch_record($query);

      if($userCheck) {
        $username = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['username']))));

        $password = escape_this_string(htmlspecialchars(strip_tags(trim($_POST['password']))));
        $userid = fetch_record("SELECT id FROM users WHERE username = '$username'")['id'];
        $userPassword = fetch_record("SELECT password FROM users WHERE username = '$username'")['password'];

        // check if password is correct
        if(password_verify($password, $userPassword)) {
          $_SESSION['login-message'] = "Success!";
          $_SESSION['user-id'] = $userid;
          $_SESSION['username'] = $username;
          $_SESSION['password'] = $password;
          header('Location: feed.php');
        } else {
          $_SESSION['login-message'] = "Password incorrect! Try again.";
        }
      } else {
        $_SESSION['login-message'] = "Username incorrect! Try again.";
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Log In</title>
    <link rel="stylesheet" href="./styles/login.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" rel="stylesheet">
  </head>
  <body>

    <div class="container">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h3>Log In</h3>
          <p>
            <?php echo $_SESSION['login-message'];
            $_SESSION['login-message'] = ""; ?>
          </p>
          <input type="text" name="username" value="<?php echo $username; ?>" class="login-input" autofocus placeholder="<?php echo $usernameError; ?>">
          <input type="password" name="password" value="" class="login-input" placeholder="<?php echo $passError; ?>">
          <br><br>
          <input type="submit" name="" class="btn btn-light" value="Log In">
          <p>No account yet? <a href="./register.php">Register here</a>.</p>
      </form>
    </div>
  </body>
</html>

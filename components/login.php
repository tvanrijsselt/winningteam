<?php

  require_once('../connect.php');
  session_start();

  // check if a user is logged in, if so redirect straight to account. otherwise show the login page as normal
  if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $userid = $_SESSION['user-id'];
    header("Location: account.php");
  }

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = escape_this_string($_POST['username']);
    $password = escape_this_string($_POST['password']);
    $userid = fetch_record("SELECT id FROM users WHERE username = '$username'")['id'];
    $userPassword = fetch_record("SELECT password FROM users WHERE username = '$username'")['password'];

    if(password_verify($password, $userPassword)) {
      $_SESSION['login-message'] = "Success!";
      $_SESSION['user-id'] = $userid;
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
      header('Location: account.php');
    } else {
      $_SESSION['login-message'] = "Fail!";
    }
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Log In</title>
  </head>
  <body>

    Log in to change your Twitter account.
    <br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group row justify-content-center">
        <div class="col">
          <br>
          <label for="username" class="font-weight-bold login-input-label">Username</label>
          <input type="text" name="username" value="<?php echo $username; ?>" class="login-input" autofocus>
          <br>
          <label for="password" class="font-weight-bold login-input-label">Password</label>
          <input type="password" name="password" value="" class="login-input">
          <br><br>
          <input type="submit" name="" class="btn btn-light" value="Log In">
          <br><br>
          <?php echo $_SESSION['login-message'];
          $_SESSION['login-message'] = ""; ?>
        </div>
      </div>
    </form>
  </body>
</html>

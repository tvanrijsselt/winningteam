<?php

  require_once('../connect.php');
  session_start();

  // check if a user is logged in, otherwise block account.php and redirect to the login page.
  if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $userid = $_SESSION['user-id'];
  } else {
    header ("Location: login.php");
  }

?>

<?php

  $show_tweets = "SELECT tweet, tweets.id FROM tweets JOIN users ON tweets.user_id = users.id WHERE username = '{$_SESSION['username']}' ORDER BY tweets.id DESC";

  // Get account info to display in the input fields
  $currentFirstName = fetch_record("SELECT firstname FROM users WHERE username = '$username'")['firstname'];
  $currentLastName = fetch_record("SELECT lastname FROM users WHERE username = '$username'")['lastname'];
  $currentEmail = fetch_record("SELECT email FROM users WHERE username = '$username'")['email'];
  $currentBiography = fetch_record("SELECT bio FROM users WHERE username = '$username'")['bio'];
  $currentCountry = fetch_record("SELECT country FROM users WHERE username = '$username'")['country'];
  $currentBirthdate = fetch_record("SELECT birthdate FROM users WHERE username = '$username'")['birthdate'];

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Account</title>
    <link rel="stylesheet" href="./styles/tweet.css">
    <link rel="stylesheet" href="./styles/account.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>

    <?php include_once('navbar.php'); ?>

    <h2>Welcome to the admin page, <?php echo $username; ?>!</h2>

    <p class="succes-message">
    <?php

      // display confirmation or fail messages when the user updates his/her account information
      if(!empty($_SESSION['message-success'])) {
        echo "<strong style='color: green;'>Success:</strong> " . $_SESSION['message-success'];
        $_SESSION['message-success'] = "";
        $_SESSION['errors'] = array();
      }
      if(!empty($_SESSION['message-fail'])) {
        echo "<strong style='color: red;'>Fail:</strong> " . $_SESSION['message-fail'];
        $_SESSION['message-fail'] = "";
        $_SESSION['errors'] = array();
      }

      // display error messages, if any.
      if(isset($_SESSION['errors'])) {
        foreach($_SESSION['errors'] as $error) {
          echo "<p><strong style='color: red;'>Error:</strong> " . $error . "</p>" . " ";
          $_SESSION['errors'] = array();
        }
      }
      ?>
    </p>

    <!-- Show profile pic -->
    <img src="<?php echo fetch_record("SELECT profile_pic FROM users WHERE users.id = $userid")['profile_pic']; ?>" alt="" style="height: 100px; width: 100px; border-radius: 100%; margin-top: 8px;">

    <form class="" action="./tweet-account-actions.php" method="post">
      <!-- <label for="">Change profile photo</label> -->
      <input type="text" name="new_photo" value="" class="account__change-input" placeholder="Change profile photo">
      <br><br>
      <input class="account__submit-button" type="submit" name="edit_photo_submit" value="Submit">
    </form>


    <h4>Personal Information</h4>

    <!-- FORMS FOR EDITING ACCOUNT INFORMATION -->
    <!-- <form action="./tweet-account-actions.php" method="post">
      <div class="form-group row justify-content-center">
        <div class="col">
          <br>
          <label for="change-firstname" class="font-weight-bold login-input-label">Change first name</label>
          <input class="account__change-input" type="text" name="firstname" value="<?php echo $currentFirstName ?>" class="login-input" id="change-firstname">
          <input type="hidden" name="action" value="firstname">
          <br>
          <label for="lastname" class="font-weight-bold login-input-label">Change last name</label>
          <input class="account__change-input" type="text" name="lastname" value="<?php echo $currentLastName ?>" class="login-input">
          <input type="hidden" name="action" value="lastname">
          <br>
          <label for="email" class="font-weight-bold login-input-label">Change email</label>
          <input class="account__change-input" type="email" name="email" value="<?php echo $currentEmail ?>" class="login-input">
          <input type="hidden" name="action" value="email">
          <br><br>
          <label for="biography" class="font-weight-bold login-input-label">Change biography</label>
          <input class="account__change-input" type="text" name="biography" value="<?php echo $currentBiography; ?>">
          <input type="hidden" name="action" value="bio">
          <br>
          <label for="country" class="font-weight-bold login-input-label">Change country</label>
          <input class="account__change-input" type="text" name="country" value="<?php echo $currentCountry; ?>" class="login-input">
          <input type="hidden" name="action" value="country">
          <br>
          <label for="birthdate" class="font-weight-bold login-input-label">Change birthdate</label>
          <input class="account__change-input" type="date" name="birthdate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $currentBirthdate; ?>" class="login-input">
          <input type="hidden" name="action" value="birthdate">
          <input class="account__submit-button" type="submit" name="action" class="btn btn-light" value="Submit Changes">
        </div>
      </div>
    </form> -->
    
    <form action="./tweet-account-actions.php" method="post">
      <div>
        <div>
        <label for="change-firstname" class="font-weight-bold login-input-label">Change first name</label>
          <input class="account__change-input" type="text" name="firstname" value="<?php echo $currentFirstName ?>" class="login-input" id="change-firstname">
          <input type="hidden" name="action" value="firstname">
          <input class="account__submit-button" type="submit" class="btn btn-light" value="Submit Changes">
        </div>
      </div>
    </form>
    
    <form action="./tweet-account-actions.php" method="post">
      <div>
        <div>
          <label for="lastname" class="font-weight-bold login-input-label">Change last name</label>
          <input class="account__change-input" type="text" name="lastname" value="<?php echo $currentLastName ?>" class="login-input">
          <input type="hidden" name="action" value="lastname">
          <input class="account__submit-button" type="submit" class="btn btn-light" value="Submit Changes">
        </div>
      </div>
    </form>
    
    <form action="./tweet-account-actions.php" method="post">
      <div>
        <div>
        <label for="email" class="font-weight-bold login-input-label">Change email</label>
          <input class="account__change-input" type="email" name="email" value="<?php echo $currentEmail ?>" class="login-input">
          <input type="hidden" name="action" value="email">
          <input class="account__submit-button" type="submit" class="btn btn-light" value="Submit Changes">
        </div>
      </div>
    </form>
    
    <form action="./tweet-account-actions.php" method="post">
      <div>
        <div>
        <label for="biography" class="font-weight-bold login-input-label">Change biography</label>
          <input class="account__change-input" type="text" name="biography" value="<?php echo $currentBiography; ?>">
          <input type="hidden" name="action" value="bio">
          <input class="account__submit-button" type="submit" class="btn btn-light" value="Submit Changes">
        </div>
      </div>
    </form>

    <form action="./tweet-account-actions.php" method="post">
      <div>
        <div>
        <label for="country" class="font-weight-bold login-input-label">Change country</label>
          <input class="account__change-input" type="text" name="country" value="<?php echo $currentCountry; ?>" class="login-input">
          <input type="hidden" name="action" value="country">
          <input class="account__submit-button" type="submit" class="btn btn-light" value="Submit Changes">
        </div>
      </div>
    </form>

    <form action="./tweet-account-actions.php" method="post">
      <div>
        <div>
        <label for="birthdate" class="font-weight-bold login-input-label">Change birthdate</label>
          <input class="account__change-input" type="date" name="birthdate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $currentBirthdate; ?>" class="login-input">
          <input type="hidden" name="action" value="birthdate">
          <input class="account__submit-button" type="submit" class="btn btn-light" value="Submit Changes">
        </div>
      </div>
    </form>

    <form class="" action="./change-password.php" method="post">
      <h4>Password</h4>
      <p>
        <?php 
          if(!empty($_SESSION['message-password'])) {
            echo "<strong style='color: green;'>Success:</strong> " . $_SESSION['message-password'];
            $_SESSION['message-password'] = "";
            $_SESSION['errors'] = array();
          }

          // display error messages, if any.
          if(isset($_SESSION['errors-pass'])) {
            foreach($_SESSION['errors-pass'] as $error) {
              echo "<p><strong style='color: red;'>Error:</strong> " . $error . "</p>" . " ";
              $_SESSION['errors-pass'] = array();
            }
          }
      ?>
      </p>
      <label for="">Current Password</label> <input class="account__change-input" type="password" name="current-password" value="" class="login-input" placeholder="**********">
      <br>
      <label for="">New Password</label> <input class="account__change-input" type="password" name="new-password" value="" class="login-input">
      <br><br>
      <input type="hidden" name="action" value="password">
      <input class="account__submit-button" type="submit" name="" value="Change Password">
    </form>

    <!-- FORM FOR DELETING TWEET(S) -->
    <form class="" action="./tweet-account-actions.php" method="post">
      <h3>Delete tweet(s)</h3>
      <?php foreach(fetch_all($show_tweets) as $tweet): ?>
        <input type="checkbox" name="tweet[]" value="<?php echo $tweet['id']; ?>"><label class="label__delete-tweet"><?php echo $tweet['tweet']; ?></label><br>
      <?php endforeach; ?>
      <br>
      <input class="account__submit-button" type="submit" name="delete-tweets" value="Delete Tweet(s)" onclick="return confirm('Are you sure you want to delete this tweet?');">
    </form>

    <form class="" action="./tweet-account-actions.php" method="post">
      <h3>Edit tweet(s)</h3>
      <p>
        <?php 
          if(!empty($_SESSION['message-success-tweet'])) {
            echo "<strong style='color: green;'>Success:</strong> " . $_SESSION['message-success-tweet'];
            $_SESSION['message-success-tweet'] = "";
            $_SESSION['errors'] = array();
          }
      ?>
      </p>
      <select class="" name="tweet_id">
        <?php foreach(fetch_all($show_tweets) as $tweet): ?>
        <option value="<?php echo $tweet['id']; ?>"><?php echo $tweet['tweet']; ?></option>
        <?php endforeach; ?>
      </select>
      <br><br>
      <input class="tweet-post-input" type="text" name="edit_tweet" placeholder="Change the text of your tweet">
      <br>
      <input class="tweet-post-input" type="text" name="edit_tweet-photo" placeholder="Change the photo of your tweet">
      <br><br>
      <input type="hidden" name="action" value="edit_tweet_hidden">
      <input class="account__submit-button" type="submit" name="edit_tweet_submit" value="Edit tweet" onclick="return confirm('Are you sure you want to update this tweet?');">
    </form>

    <!-- <br><br><br>
    <h3>DESIGN</h3>
    <div class="tweet-container">
      <div class="user-info">
        <img src="<?php echo fetch_record("SELECT profile_pic FROM users WHERE users.id = $userid")['profile_pic']; ?>" alt="">
        <ul>
          <li id="fullname"><?php echo fetch_record("SELECT firstname FROM users WHERE users.id = $userid")['firstname'];?> <?php echo fetch_record("SELECT lastname FROM users WHERE users.id = $userid")['lastname']; ?></li>
          <li id="username">@<?php echo fetch_record("SELECT username FROM users WHERE users.id = $userid")['username']; ?></li>
        </ul>
      </div>
      <div class="tweet">
        <p><?php echo fetch_record("SELECT tweet, users.id FROM tweets JOIN users ON tweets.user_id = users.id WHERE users.id = $userid")['tweet']; ?></p>
      </div>
    </div> -->

    <br><br><br>

    <!-- show tweets -->
    <!-- <?php foreach(fetch_all("SELECT tweet, tweets.id, firstname, lastname, profile_pic, username, users.id, tweets.picture FROM tweets JOIN users ON tweets.user_id = users.id WHERE users.id = $userid") as $tweet): ?>
      <div class="tweet-container">
        <div class="user-info">
          <img src="<?php echo $tweet['profile_pic']?>" alt="" class="tweet-userimg">
          <ul class="tweet__name">
            <li id="fullname"><?php echo $tweet['firstname']; ?> <?php echo $tweet['lastname']; ?></li>
            <li id="username"><span class="at">@</span><?php echo $tweet['username']; ?></li>
          </ul>
        </div>
        <div class="tweet">
          <p class="tweet__content"><?php echo $tweet['tweet']; ?></p>
          <img src="<?php echo $tweet['picture']; ?>" alt="" class="tweet__img">
        </div>
      </div>
      <br>
    <?php endforeach; ?> -->

    <div class="tweet-post-container">
      <!-- <h4>Tweet something</h4> -->
      <form class="" action="./tweet-account-actions.php" method="post">
        <h4>Tweet something</h4>
        <input type="text" name="tweet" value="" class="tweet-post-input" placeholder="Post a new tweet">
        <input type="text" name="photo" value="" placeholder="with a photo?" class="tweet-post-input">
        <input type="hidden" name="action" value="post_tweet">
        <input class="account__submit-button" type="submit" name="post_tweet_submit" value="Post tweet">
      </form>
    </div>

    <br><br>
    <div class="profile-block">
      <div class="profile-block__info">
        <img src="<?php echo fetch_record("SELECT profile_pic FROM users WHERE users.id = $userid")['profile_pic']; ?>" alt="" class="profile-block__image">
        <h3 class="profile-block__name"><?php echo $tweet['firstname']; ?> <?php echo $tweet['lastname']; ?></h3>
        <p class="profile-block__username"><span class="at">@</span><?php echo fetch_record("SELECT username FROM users WHERE users.id = $userid")['username']; ?></p>
        <p class="profile-block__bio"><?php echo fetch_record("SELECT bio FROM users WHERE users.id = $userid")['bio']; ?></p>
      </div>
      <div class="profile-block__stats">
        <div class="profile-block__stats--tweets">
          <p><?php echo fetch_record("SELECT COUNT(tweets.id) FROM tweets JOIN users ON tweets.user_id = users.id WHERE users.id = $userid;")['COUNT(tweets.id)']; ?></p>
          <h3>Tweets</h3>
        </div>
        <div class="profile-block__stats--following">
          <p><?php echo fetch_record("SELECT COUNT(followings.id) FROM followings WHERE followings.user_id = $userid;")['COUNT(followings.id)']; ?></p>
          <h3>Following</h3>
        </div>
        <div class="profile-block__stats--followers">
          <p><?php echo fetch_record("SELECT COUNT(followings.id) FROM followings JOIN users ON followings.user_id = users.id WHERE followings.follower_id = $userid;")['COUNT(followings.id)']; ?></p>
          <h3>Followers</h3>
        </div>
      </div>
    </div>
  </body>
</html>

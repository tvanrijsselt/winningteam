<!DOCTYPE html>

<!-- to do:
    - styling
    - logout
    - user -> ingelogde user
    - werkende links
-->

<html>
    <head>
        <link rel='stylesheet' type='text/css' href='styles/femke_styles.css' />
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <?php include_once('../queries.php'); ?>
    </head>

    <body>
        <ul class='navbar'>
            <li><a href="feed.php"><i class="fa fa-home fa-lg"></i></a></li>
            <li class='user' style="float: right">
                <a href="account.php">
                    <img src="<?php echo fetch_record("SELECT profile_pic FROM users WHERE users.id = $userid")['profile_pic']; ?>" 
                        alt="" style="height: 30px; width: 30px; border-radius: 100%; float: left; margin: 0 4px 0 0;">
                    <?php echo $user_logged_in['firstname'] . ' ' . $user_logged_in['lastname']; ?>
                </a>
                <div class='dropdown'>
                    <a href="account.php"><i class='fa fa-user-circle-o fa-lg'></i> Account</a>
                    <a href="logout.php"><i class='fa fa-sign-out fa-lg'></i> Logout</a>
                </div>
            </li>
        </ul>
    </body>


</html>
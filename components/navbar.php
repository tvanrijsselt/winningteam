<!DOCTYPE html>

<!-- to do:
    - styling
    - logout
    - user -> ingelogde user
    - werkende links
-->

<html>
    <head>
    <style>
            
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                background-color: white;
                box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
            }

            li {
                float: left;
            }

            li a {
                display: block;
                padding: 8px;
                text-decoration: none;
                color: rgb(0, 128, 255);
                font-weight: 600;
            }

            .dropdown {
                display: none;
                position: absolute;
                right: 0;
                z-index: 1;
                background-color: white;
            }

            .user:hover .dropdown {
                display: block;
            }

            .navbar a:hover {
                background-color: rgb(0, 128, 255);
                color: white;        
            }

        </style>

        <?php include_once('../queries.php'); ?>
    </head>

    <body>
        <ul class='navbar'>
            <li><a href="feed.php"><i class="fa fa-home fa-lg"></i></a></li>
            <li class='user' style="float: right">
                <a href="account.php">
                    <i class='fa fa-user-circle-o fa-lg'></i>
                    <img src="<?php echo fetch_record("SELECT profile_pic FROM users WHERE users.id = $userid")['profile_pic']; ?>" alt="" style="height: 30px; width: 30px; border-radius: 100%; position: absolute; top: 5px; right: 121px; margin-right: 0px;">
                    <?php echo $user_logged_in['firstname'] . ' ' . $user_logged_in['lastname']; ?>
                </a>
                <div class='dropdown'>
                    <a href="account.php">Account</a>
                    <a href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </body>


</html>
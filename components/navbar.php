<!DOCTYPE html>

<!-- to do:
    - styling
    - logout
    - user -> ingelogde user
    - werkende links
-->

<html>
    <head>
    </head>
        <style>
            
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                border-bottom: black solid 1px;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                background-color: white;
            }

            li {
                float: left;
            }

            li a {
                display: block;
                padding: 8px;
                text-decoration: none;
                color: black;
            }

            .dropdown {
                display: none;
                position: absolute;
                right: 0;
                z-index: 1;
            }

            .user:hover .dropdown {
                display: block;
            }

            .dropdown a:hover {
                background-color: green;
            }
        </style>

    <body>
        <ul class='navbar'>
            <li><a href="feed.php">Twitter</a></li>
            <li class='user' style="float: right">
                <a href="account.php">User</a>
                <div class='dropdown'>
                    <a href="account.php">Account</a>
                    <a href="#">Logout</a>
                </div>
            </li>
        </ul>
    </body>


</html>
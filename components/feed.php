<!DOCTYPE html>
<html>
<head>

<?php require_once('../connect.php'); ?>
<?php include_once('../queries.php'); ?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<!-- <link rel='stylesheet' type='text/css' href='feed_style.css' /> -->
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


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

    body {
        font-family: 'Poppins', sans-serif;
        background: #f4f4f4;
    }
    
    .container {
        width: 50%;
        margin: 50px auto;  
    }

    .feed_buttons {
        width: 100%;
        display: grid;
        grid-template: 1fr / 1fr 1fr 1fr;
        grid-gap: 10px;
    }

    .feed_buttons button {
        background-image: #00d2ff;  /* fallback for old browsers */
        background-image: -webkit-linear-gradient(to left, #3a7bd5, #00d2ff);  /* Chrome 10-25, Safari 5.1-6 */
        background-image: linear-gradient(to left, #3a7bd5, #00d2ff); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        padding: 10px ;
        font-family: 'Poppins', sans-serif;
        border: none;
        text-transform: uppercase;
        color: #fff;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
    }

    .feed_buttons button:hover {
        background-image: #00d2ff;  /* fallback for old browsers */
        background-image: -webkit-linear-gradient(to right, #3a7bd5, #00d2ff);  /* Chrome 10-25, Safari 5.1-6 */
        background-image: linear-gradient(to right, #3a7bd5, #00d2ff); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    .feed_buttons button:focus {
        opacity: 0.3;
    }

    .tweet {
        width: 300px;
        border-radius: 10px;
        margin: 10px auto;
        background: #fff;
        box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
        padding: 20px 15px;
        overflow: hidden;
        clear: both;
    }

    .tweet_buttons {
        background-color: white;
        display: grid;
        grid-template: 1fr / 1fr 1fr;
    }

    #create_reply {
        padding: 5px 10px;
        font-family: 'Poppins', sans-serif;
        border-radius: 2px;
        border: none;
        background-color: white;
        color: #4B4F56;
        cursor: pointer;
    }

    #create_reply:hover {
        background-color: #E9EBEE;
    }
</style>

</head>

<body>
<!-- include navbar on feed -->
<?php include_once('navbar.php'); ?>

<ul class='navbar'>
            <li><a href="feed.php"><i class="fa fa-home fa-lg"></i></a></li>
            <li class='user' style="float: right">
                <a href="account.php">
                    <i class='fa fa-user-circle-o fa-lg'></i>
                    <?php echo $user_logged_in['firstname'] . ' ' . $user_logged_in['lastname']; ?>
                </a>
                <div class='dropdown'>
                    <a href="account.php">Account</a>
                    <a href="#">Logout</a>
                </div>
            </li>
        </ul>
<div class="container">
    <div class='feed_buttons'>
        <!-- button to show all tweets -->
        <button id='feed' onclick='showFeed()'>All tweets</button>
        <!-- button to show favorite tweets -->
        <button id='feed_faves' onclick='feedFaves()'>Favorites</button>
        <!-- button to show tweets of people you follow -->
        <button id='feed_followings' onclick='feedFollowings()'>Following</button>
    </div>

    <!-- feed for all tweets-->
    <div class='tweets'>
        <?php foreach ($tweets as $post): ?>
            <div class='tweet'>
                <!-- display user -->
                <?php include('user.php'); ?>
                <!-- favorite button, display only if tweet not in faves -->
                <div class='tweet_buttons'>
                    <?php include('fav_button.php'); ?>
                    <!-- button to open reply form -->
                    <button id="create_reply" 
                        onclick=<?php echo 'create_reply(' . $post['id'] . ')'; ?>>
                        <i class='fa fa-comment-o'></i> Reply
                    </button>
                </div>
            </div>
            
        <?php endforeach; ?>
    </div> <!-- end tweets div -->

    <!-- div for faves -->
    <div class='faves'>
        <?php foreach ($faves as $post): ?>
            <div class='tweet' id=<?php echo "fav" . $post['id']; ?>>
                <!-- display user -->
                <?php include('user.php'); ?>
                <!-- unfavorite button -->
                <div class='tweet_buttons'>
                    <button id="unfavorite" onclick=<?php echo "unfavorite(" . $post['id'] . ")";?>>
                        <i class="fa fa-check"></i> Unfavorite
                    </button>
                    <!-- button to open reply form -->
                    <button id="create_reply" 
                        onclick=<?php echo 'create_reply(' . $post['id'] . ')'; ?>>
                        <i class='fa fa-comment-o'></i> Reply
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div> <!-- end faves div -->

    <!-- div for followings -->
    <div class="followings">
        <?php foreach($followings as $post): ?>
            <div class='tweet'>
                <!-- display user -->
                <?php include('user.php'); ?>
                <!-- favorite button, display only if tweet not in faves -->
                <div class='tweet_buttons'>
                    <?php include('fav_button.php'); ?>
                    <!-- button to open reply form -->
                    <button id="create_reply" 
                        onclick=<?php echo 'create_reply(' . $post['id'] . ')'; ?>>
                        <i class='fa fa-comment-o'></i> Reply
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div> <!-- end followings div -->
</div> <!-- end container div -->

<!-- popup with tweet and all replies -->
<div id='show_tweet' class='modal'>
</div>

<!-- popup with user's tweet -->
<div id="user_tweets" class="modal">
</div>

<div id='reply' class='modal'></div>

<script>
    $(document).ready(function() {
        $('.faves').hide();
        $('.followings').hide();
    }); // end document ready  

        // display all tweets
        function showFeed() {
            $(".tweets").show();
            $('.followings').hide();
            $('.faves').hide();
        } //end showFeed function
      
        // display faves
        function feedFaves() {
                $(".tweets").hide();
                $('.followings').hide();
                $('.faves').show();  
        }; // end feedFaves function

        // display followings
        function feedFollowings() {
                $(".faves").hide();
                $(".tweets").hide();
                $('.followings').show();
        }; // end feedFollowings function

        // show tweet + replies and everything
        function showTweet(id) {
            $.post('show_tweet.php', {
                id: id
            }, (data, status) => {
                $('#show_tweet').html(data).modal();
            })
        }; //end showTweet function

        // show user's tweets
        function showUserTweets(userid) {
            $.post('user_tweets.php', {
                userid: userid
            }, (data,status) => {
                $("#user_tweets").html(data).modal();
            })
        }; // end showUserTweets
    
        // favorite a tweet
        function favorite(id, userid) {
            $.post('favorite.php', {
                id: id,
                userid: userid
            }, (data,status) => {
                //reload faves and tweets without reloading whole page
                $('.faves').load('feed.php .faves');
                $('.tweets').load('feed.php .tweets'); 
                $('.followings').load('feed.php .followings');  
                
            })
        }; // end favorite

        //unfavorite a tweet
        function unfavorite(id) {
            $.post('unfavorite.php', {
                id: id
            }, (data,status) => {
                // remove from DOM
                $("#fav"+id).remove();  
                // reload tweets
                $('.tweets').load('feed.php .tweets');
                $('.followings').load('feed.php .followings')                
            })
        }; // end unfavorite


        // follow a user
        function follow(userid) {
            $.post('follow.php', {
                userid: userid
            }, (data,status) => {
                //remove follow button from modal
                $("#follow").remove();
                //reload followings feed
                $('.followings').load('feed.php .followings');
            })
        };

        // unfollow a user
        function unfollow(id) {
            $.post('unfollow.php', {
                id: id
            }, (data, status) => {
                //remove button
                $('#unfollow').remove();
                //reload followings feed
                $('.followings').load('feed.php .followings');
            })
        }

        // open reply form
        function create_reply(id) {
            $.post('reply.php', {
                id: id
            }, (data,status) => {
                $('#reply').html(data).modal();
            })
        };
    
</script>

</body>

</html>
<!DOCTYPE html>
<html>
<head>

<?php require_once('../connect.php'); ?>
<?php include_once('../queries.php'); ?>
<?php session_start();

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userid = $_SESSION['user-id'];
  }
?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<link rel='stylesheet' type='text/css' href='styles/femke_styles.css' />
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .tweet-post-container {
        width: 75%;
        border-radius: 10px;
        margin: 10px auto;
        background: #fff;
        box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
        padding: 10px 15px;
    }

    .tweet-post-input {
        width: 100%;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
    }

    h4 {
        text-transform: uppercase;
        margin-bottom: 8px;
        margin-top: 0px;
        text-align: center;
    }

    .account__submit-button {
        padding: 5px 10px;
        font-family: 'Poppins', sans-serif;
        border-radius: 2px;
        border: 1px solid transparent;
        background-color: #f6f7f9;
        border: 1px solid #DADFE2;
        color: #4B4F56;
        cursor: pointer;
        box-shadow: 0 0px 5px 0px rgba(0, 0, 0, 0.1);
        float: right;
        }

        .account__submit-button:hover {
            background-color: #E9EBEE;
        }
</style>

</head>

<body>
<!-- include navbar on feed -->
<?php include_once('navbar.php'); ?>

<div class="container">
    <div class='feed_buttons'>
        <!-- button to show all tweets -->
        <button id='feed' onclick='showFeed()'>All tweets</button>
        <!-- button to show favorite tweets -->
        <button id='feed_faves' onclick='feedFaves()'>Favorites</button>
        <!-- button to show tweets of people you follow -->
        <button id='feed_followings' onclick='feedFollowings()'>Following</button>
    </div>

    <!-- show registration message after succesfully registering -->
    <?php 

        if(!empty($_SESSION['register-message'])) {
            echo "<p><strong style='color: green;'>Success:</strong> " . $_SESSION['register-message'];
            $_SESSION['register-message'] = "";
        }
    ?>

    <div class="tweet-post-container">
      <!-- <h4>Tweet something</h4> -->
      <form class="" action="./tweet-account-actions.php" method="post">
        <h4>Tweet something</h4>
        <textarea type="text" name="tweet" value="" class="tweet-post-input" maxlength='280' placeholder="Post a new tweet"></textarea>
        <input id="photo" type="text" name="photo" value="" placeholder="With a photo?" class="tweet-post-input">
        <input type="hidden" name="action" value="post_tweet_feed">
        <input class="account__submit-button" type="submit" name="post_tweet_submit" value="Post tweet">
      </form>
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
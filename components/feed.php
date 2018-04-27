<!DOCTYPE html>
<html>
<head>

<?php require_once('../connect.php'); ?>
<?php include_once('../queries.php'); ?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<style>
    img {
        width: 50%;
        height: auto;
    }

    .faves {
        display: none;
        color: red;
    }

    .followings {
        display: none;
    }
    
</style>

</head>

<body>
<?php include_once('navbar.php'); ?>

<div class="container" style="margin-top: 50px">
    <!-- button to show only favorite tweets or all tweets -->
    <button id='feed' onclick='showFeed()'>Show all tweets</button>

    <button id='feed_faves' onclick='feedFaves()'>Show favorite tweets</button>

    <button id='feed_followings' onclick='feedFollowings()'>Show tweets of people you follow</button>

    <!-- feed for all tweets-->
    <div class='tweets'>
        <?php foreach ($tweets as $post): ?>
            <div class='tweet'>
                <!-- display user -->
                <p><a href="#" onclick=<?php echo "showUserTweets(" . $post['userid'] .")";?>><?php echo $post['firstname'] . ' ' . $post['lastname']; ?></a></p>
                <!-- only display picture if one has been uploaded -->
                <?php if ($post['picture'] != ''): ?>
                    <img src='<?php echo $post['picture']; ?>'/>
                <?php endif; ?>
                <!-- display tweet -->
                <p><?php echo $post['tweet']; ?></p>
                <!-- favorite button, display only if tweet not in faves -->
                <?php if (!fetch_record($check_faves . $post['id'])): ?>
                    <button onclick=<?php echo "favorite(" . $post['id'] . "," . $post['userid'] . ")";?>>Add to favorites</button>
                <?php endif;?>
            </div>
        <?php endforeach; ?>
    </div> <!-- end tweets div -->

    <!-- div for faves -->
    <div class='faves'>
        <?php foreach ($faves as $fav): ?>
            <div class='fav' id=<?php echo "fav" . $fav['id']; ?>>
                <!-- display user -->
                <p><?php echo $fav['firstname'] . ' ' . $fav['lastname']; ?></p>
                <!-- only display picture if one has been uploaded -->
                <?php if ($fav['picture'] != ''): ?>
                    <img src='<?php echo $fav['picture']; ?>'/>
                <?php endif; ?>
                <!-- display tweet -->
                <p><?php echo $fav['tweet']; ?></p>
                <!-- unfavorite button -->
                <button id="unfavorite" onclick=<?php echo "unfavorite(" . $fav['id'] . ")";?>>Remove from favorite</button>
            </div>
        <?php endforeach; ?>
    </div> <!-- end faves div -->

    <!-- div for followings -->
    <div class="followings">
        <?php foreach($followings as $follow): ?>
            <div class='follow'>
                <!-- display user -->
                <p><?php echo $follow['firstname'] . ' ' . $follow['lastname'];?></p>
                <!-- only display picture if one has been uploaded -->
                <?php if ($follow['picture'] != ''): ?>
                    <img src='<?php echo $follow['picture']; ?>'/>
                <?php endif; ?>
                <!-- display tweet -->
                <p><?php echo $follow['tweet']; ?></p>
            </div>
        <?php endforeach; ?>
    </div> <!-- end followings div -->
</div> <!-- end container div -->

<!-- popup with user's tweet 
    to fix: now it shows all tweets -> change to just one user's tweets (probably with $.post) 
-->
<div id="user_tweets" class="modal">
    
</div>


<script>
    $(document).ready(function() {
      }); // end document ready  
        
        //
        function showFeed() {
            $(".tweets").css('display', 'initial');
            $('.followings').css('display', 'none');
            $('.faves').css('display', 'none');
        }
      
        // display faves
        function feedFaves() {
                $(".tweets").css('display', 'none');
                $('.followings').css('display', 'none');
                $('.faves').css('display', 'initial');  
        }; // end feedFaves function

        // display followings
        function feedFollowings() {
                $(".faves").css('display', 'none');
                $(".tweets").css('display', 'none');
                $('.followings').css('display', 'initial');
        }; // end feedFollowings function

        // show user's tweets
        function showUserTweets(id) {
            $.post('user_tweets.php', {
                id: id
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
                $('.tweets').load('feed.php .tweet'); 
                // remove favorite button (mostly for the modal) 
                $('#fav_button' + id).remove(); 
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
                $('.tweets').load('feed.php .tweet');
            })
        }; // end unfavorite

        // follow a user
        function follow(userid) {
            $.post('follow.php', {
                userid: userid
            }, (data,status) => {
                //remove follow button from modal
                $("#follow").remove();
                $('.followings').load('feed.php .followings');
            })
        };

        function unfollow(id) {
            $.post('unfollow.php', {
                id: id
            }, (data, status) => {
                $('#unfollow').remove();
                $('.followings').load('feed.php .followings');
            })
        }
    
</script>

</body>

</html>
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
    
</style>

</head>

<body>
<?php include_once('navbar.php'); ?>

<div style="margin-top: 50px">
    <button id='feed_faves' onclick='feedFaves()'>Show favorite tweets</button>

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
                <!-- favorite button -->
                <button id='favorite' onclick=<?php echo "favorite(" . $post['id'] . ")";?>>Add to favorites</button>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- div for faves -->
    <div class='faves'>
        <?php foreach ($faves as $fav): ?>
            <div class='fav'>
                <!-- display user -->
                <p><?php echo $post['firstname'] . ' ' . $post['lastname']; ?></p>
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
    </div>
</div>

<!-- popup with user's tweet 
    to fix: now it shows all tweets -> change to just one user's tweets (probably with $.post) 
-->
<div id="user_tweets" class="modal">
    
</div>


<script>
    $(document).ready(function() {
      }); // end document ready  
        
      
        // display feed or faves
        var showFeed=true;
        function feedFaves() {
            if (showFeed === true) {
                $(".tweets").css('display', 'none');
                $('.faves').css('display', 'initial');
                $('#feed_faves').html('Show all tweets');
                showFeed=false;
            } else {
                $(".tweets").css('display', 'initial');
                $('.faves').css('display', 'none');
                $('#feed_faves').html('Show favorite tweets');
                showFeed=true;
            }
        }; // end feedFaves function

        // show user's tweets
        function showUserTweets(id) {
            $.post('user_tweets.php', {
                id: id
            }, (data,status) => {
                $("#user_tweets").html(data).modal();
            })
        }; // end showUserTweets
    
        // favorite a tweet
        function favorite(id) {
            $.post('favorite.php', {
                id: id
            }, (data,status) => {
                // change button style
                $("#favorite").css("background-color", "blue");
                //reload faves without reloading whole page
                $('.faves').load('feed.php .faves');
            })
        }; // end favorite

        //unfavorite a tweet
        function unfavorite(id) {
            $.post('unfavorite.php', {
                id: id
            }, (data,status) => {
                //reload faves without reloading whole page
                $('.faves').load('feed.php .faves');
            })
        }; // end unfavorite
    
</script>

</body>

</html>
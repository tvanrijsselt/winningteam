<!DOCTYPE html>

<html>
<head>
    <style>
        #favorite, #unfavorite {
            padding: 5px 10px;
            font-family: 'Poppins', sans-serif;
            border-radius: 2px;
            border: none;
            background-color: white;
            color: #4B4F56;
            cursor: pointer;
        }
        #favorite:hover {
            background-color: #E9EBEE;
        }
        #unfavorite:hover {
            background-color: #E9EBEE;
        }

        .user_and_reply {
            width: 80%;
            margin: 5px auto;
            background: #f4f4f4;
            border-radius: 10px;
            padding: 10px;
        }

        .reply-userimg {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            float: left;
            box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .reply-user-info {
            display: inline-block;
            margin-left: 10px;
        }

        .reply-user-info span {
            font-weight: 700;
            font-size: 1rem;
        }

        .reply-user-info a {
            font-size: .75rem;
            color: #717171;
            font-weight: 300;
            text-decoration: none;
        }

        .reply__content {
            padding-top: 15px;
            text-align: left;
            font-weight: 300;
            color: #717171;
        }

        .reply__content img {
            width: 100%;
            box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }
        
        .reply__content div {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php require_once('../connect.php');
      include_once('../queries.php');

$post = fetch_record($select_tweets . ' WHERE tweets.id = ' . $_POST['id']);

$show_replies = fetch_all($replies . $_POST['id'] . ' ORDER BY replies.id DESC');
?>

<?php include('user.php'); ?>
<!-- favorite button, display only if tweet not in faves -->
<div class='tweet_buttons'>
    <?php include_once('fav_button.php'); ?>
    <!-- reply button-->
    <button id="create_reply" 
        onclick=<?php echo 'create_reply(' . $post['id'] . ')'; ?>>
        <i class='fa fa-comment-o'></i> Reply
    </button>       
</div>

<?php foreach ($show_replies as $reply): ?>
    <div class='user_and_reply'>
        <a href="#" onclick=<?php echo "showUserTweets(" . $reply['userid'] .")";?>>
            <img class='reply-userimg' src=<?php if (isset($reply['profile_pic'])) {echo $reply['profile_pic'];} else {echo 'http://4.bp.blogspot.com/-zsbDeAUd8aY/US7F0ta5d9I/AAAAAAAAEKY/UL2AAhHj6J8/s1600/facebook-default-no-profile-pic.jpg';}; ?>>
        </a>
        <div class='reply-user-info'>
            <a href="#" onclick=<?php echo "showUserTweets(" . $reply['userid'] .")";?>>
                <span><?php echo $reply['firstname'] . ' ' . $reply['lastname']; ?></span>
            </a>
            <a href="#" onclick=<?php echo "showUserTweets(" . $reply['userid'] .")";?>>
                <?php echo '@' . $reply['username']; ?>
            </a>
        </div>
        <span id='created_at'><?php echo $reply['created_at']; ?></span> 

        <div class='reply__content'>
            <?php if ($reply['picture'] != ''): ?>
                <img onclick=<?php echo 'showTweet(' . $reply['id'] . ')';?> src='<?php echo $reply['picture']; ?>'/>
            <?php endif; ?>
            <!-- display tweet -->
            <div><?php echo $reply['content']; ?></div>
        </div>
    </div>
<?php endforeach;?>

</body>

</html>
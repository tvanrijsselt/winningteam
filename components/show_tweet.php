<!DOCTYPE html>

<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel='stylesheet' type='text/css' href='styles/femke_styles.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        <div class='reply__content'>        
            <span id='created_at'><?php echo date('d/m/Y H:i', strtotime($reply['created_at'])); ?></span> 

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
<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel='stylesheet' type='text/css' href='styles/femke_styles.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php require_once('../connect.php');?>
    <?php include_once('../queries.php');?>

    <?php $user_tweets = fetch_all($select_tweets . ' WHERE user_id =' . $_POST['userid'] . ' ORDER BY tweets.id DESC');?>

</head>

<body>

    <!-- display user -->
    <div class='user_page'>
        <img id='user_img' src=<?php if (isset($user_tweets[0]['profile_pic'])) {echo $user_tweets[0]['profile_pic'];} else {echo 'http://4.bp.blogspot.com/-zsbDeAUd8aY/US7F0ta5d9I/AAAAAAAAEKY/UL2AAhHj6J8/s1600/facebook-default-no-profile-pic.jpg';}; ?>>
        <div class='user__info'>
            <h2><?php echo $user_tweets[0]['firstname'] . ' ' . $user_tweets[0]['lastname']; ?></h2>
            <span><?php echo '@' . $user_tweets[0]['username']; ?></span>
            <div class='follow_btn'>
                <?php if (!fetch_record($check_followings . $user_tweets[0]['userid'])): ?>
                    <button id="follow" onclick="<?php echo "follow(" . $user_tweets[0]['userid'] . ")";?>">Follow</button>
                <?php else: ?>
                    <button id ='unfollow' onclick='<?php echo "unfollow(" . $user_tweets[0]['userid'] . ")";?>'>Unfollow</button>
                <?php endif; ?>
            </div>
            <span id='bio'><?php echo '"' . $user_tweets[0]['bio'] . '"'; ?></span>
        </div>
        
    </div>
    
    <!-- (un)follow button -->
    
    <!-- display tweets -->
    <div class='user_tweets'>
        <?php foreach ($user_tweets as $post): ?>
            
            <div class='tweet'>
            <!-- only display picture if one has been uploaded -->
                <span id='created_at'><?php echo $post['created_at']; ?></span> 
                <div class='tweet__content'>
                    <?php if ($post['picture'] != ''): ?>
                        <img class='tweet-img' 
                            onclick=<?php echo 'showTweet(' . $post['id'] . ')';?> 
                            src='<?php echo $post['picture']; ?>'/>
                    <?php endif; ?>
                    <!-- display tweet -->
                    <p onclick=<?php echo 'showTweet(' . $post['id'] . ')';?>><?php echo $post['tweet']; ?></p>
                </div>
                <div class='tweet_buttons'>
                    <?php include('fav_button.php'); ?>
                    <!-- button to open reply form -->
                    <button id="create_reply" onclick=<?php echo 'create_reply(' . $post['id'] . ')'; ?>><i class='fa fa-comment-o'></i> Reply</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>
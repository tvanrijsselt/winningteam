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
    <div class='user__info'>
        <img id='user_img' src=<?php if (isset($user_tweets[0]['profile_pic'])) {echo $user_tweets[0]['profile_pic'];} else {echo 'http://4.bp.blogspot.com/-zsbDeAUd8aY/US7F0ta5d9I/AAAAAAAAEKY/UL2AAhHj6J8/s1600/facebook-default-no-profile-pic.jpg';}; ?>>
            <h2><?php echo $user_tweets[0]['firstname'] . ' ' . $user_tweets[0]['lastname']; ?></h2>
            <span><?php echo '@' . $user_tweets[0]['username']; ?></span>
            <!-- (un)follow button -->
            <div class='follow_btn'>
                <?php if (!fetch_record($check_followings . $user_tweets[0]['userid'])): ?>
                    <button id="follow" onclick="<?php echo "follow(" . $user_tweets[0]['userid'] . ")";?>">Follow</button>
                <?php else: ?>
                    <button id ='unfollow' onclick='<?php echo "unfollow(" . $user_tweets[0]['userid'] . ")";?>'>Unfollow</button>
                <?php endif; ?>
            </div>
        </div>            
    <p id='bio'><?php echo '"' . $user_tweets[0]['bio'] . '"'; ?></p>
</div>

    <div class="profile-block__stats">
        <div class="profile-block__stats--tweets">
          <p><?php echo fetch_record("SELECT COUNT(tweets.id) FROM tweets JOIN users ON tweets.user_id = users.id WHERE users.id = " . $user_tweets[0]['userid'] . ";")['COUNT(tweets.id)']; ?></p>
          <h3>Tweets</h3>
        </div>
        <div class="profile-block__stats--following">
          <p><?php echo fetch_record("SELECT COUNT(followings.id) FROM followings WHERE followings.follower_id = " . $user_tweets[0]['userid'] . ";")['COUNT(followings.id)']; ?></p>
          <h3>Following</h3>
        </div>
        <div class="profile-block__stats--followers">
          <p><?php echo fetch_record("SELECT COUNT(followings.id) FROM followings JOIN users ON followings.user_id = users.id WHERE followings.user_id = " . $user_tweets[0]['userid'] . ";")['COUNT(followings.id)']; ?></p>
          <h3>Followers</h3>
        </div>
      </div>
    
    
    <!-- display tweets -->
    <div class='user_tweets'>
        <h3 style="text-align: center;"><?php echo '@' . $user_tweets[0]['username']; ?>'s Tweets</h3>
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
<?php require_once('../connect.php');?>
<?php include_once('../queries.php');?>

<?php
$user_tweets = fetch_all($select_tweets . ' WHERE user_id =' . $_POST['userid'] . ' ORDER BY tweets.id DESC');
?>

    <!-- display user -->
    <div class='user_and_tweet'>
        <img id='user_img' src=<?php if (isset($user_tweets[0]['profile_pic'])) {echo $user_tweets[0]['profile_pic'];} else {echo 'http://4.bp.blogspot.com/-zsbDeAUd8aY/US7F0ta5d9I/AAAAAAAAEKY/UL2AAhHj6J8/s1600/facebook-default-no-profile-pic.jpg';}; ?>>
        <div class='username'>
            <a href="#" onclick=<?php echo "showUserTweets(" . $user_tweets[0]['userid'] .")";?>><?php echo '@' . $user_tweets[0]['username']; ?></a><br>
            <span><?php echo $user_tweets[0]['firstname'] . ' ' . $user_tweets[0]['lastname']; ?></span>
        </div>
        <div class='follow_btn'>
            <?php if (!fetch_record($check_followings . $user_tweets[0]['userid'])): ?>
                <button id="follow" onclick="<?php echo "follow(" . $user_tweets[0]['userid'] . ")";?>">Follow</button>
            <?php else: ?>
                <button id ='unfollow' onclick='<?php echo "unfollow(" . $user_tweets[0]['userid'] . ")";?>'>Unfollow</button>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- (un)follow button -->
    
    <!-- display tweets -->
    <div class='user_tweets'>
        <?php foreach ($user_tweets as $post): ?>
            <div class='tweet'>
            <!-- only display picture if one has been uploaded -->
            <?php if ($post['picture'] != ''): ?>
                <img onclick=<?php echo 'showTweet(' . $post['id'] . ')';?> src='<?php echo $post['picture']; ?>'/>
            <?php endif; ?>
            <!-- display tweet -->
            <p onclick=<?php echo 'showTweet(' . $post['id'] . ')';?> ><?php echo $post['tweet']; ?></p>
            <!-- favorite button -->
            <?php include('fav_button.php'); ?>
            </div>
        <?php endforeach; ?>
    </div>


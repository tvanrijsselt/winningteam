<?php require_once('../connect.php');
      include_once('../queries.php');

$post = fetch_record($select_tweets . ' WHERE tweets.id = ' . $_POST['id']);

$show_replies = fetch_all($replies . $_POST['id']);
?>

<?php include('user.php'); ?>
<!-- favorite button, display only if tweet not in faves -->
<?php if (!fetch_record($check_faves . $post['id'])): ?>
    <button onclick=<?php echo "favorite(" . $post['id'] . "," . $post['userid'] . ")";?>>Add to favorites</button>
<?php else: ?>
    <button id='unfavorite' onclick=<?php echo "unfavorite(" . $post['id'] . ")";?>>Remove from favorite</button>
<?php endif;?>

<?php foreach ($show_replies as $reply): ?>
    <div class='user_and_tweet'>
        <img src=<?php if (isset($reply['profile_pic'])) {echo $reply['profile_pic'];} else {echo 'http://4.bp.blogspot.com/-zsbDeAUd8aY/US7F0ta5d9I/AAAAAAAAEKY/UL2AAhHj6J8/s1600/facebook-default-no-profile-pic.jpg';}; ?>>
        <div class='username'>
            <a href="#" onclick=<?php echo "showUserTweets(" . $reply['userid'] .")";?>><?php echo '@' . $reply['username']; ?></a><br>
            <span><?php echo $reply['firstname'] . ' ' . $reply['lastname']; ?></span>
        </div>
    </div>

    <?php if ($reply['picture'] != ''): ?>
        <img onclick=<?php echo 'showTweet(' . $reply['id'] . ')';?> src='<?php echo $reply['picture']; ?>'/>
    <?php endif; ?>
    <!-- display tweet -->
    <p onclick=<?php echo 'showTweet(' . $reply['id'] . ')';?>><?php echo $reply['content']; ?></p>
<?php endforeach;?>
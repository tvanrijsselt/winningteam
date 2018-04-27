<?php require_once('../connect.php');?>
<?php include_once('../queries.php');?>

<?php
$user_tweets = fetch_all($select_tweets . ' WHERE user_id =' . $_POST['id'] . ' ORDER BY tweets.id DESC');
?>

    <!-- display user -->
    <p><?php echo $user_tweets[0]['firstname'] . ' ' . $user_tweets[0]['lastname']; ?></p>
    <!-- (un)follow button -->
    <?php if (!fetch_record($check_followings . $user_tweets[0]['userid'])): ?>
        <button id="follow" onclick="<?php echo "follow(" . $user_tweets[0]['userid'] . ")";?>">Follow</button>
    <?php else: ?>
        <button id ='unfollow' onclick='<?php echo "unfollow(" .$user_tweets[0]['userid'] . ")";?>'>Unfollow</button>
    <?php endif; ?>
    <!-- display tweets -->
    <?php foreach ($user_tweets as $post): ?>
        <!-- only display picture if one has been uploaded -->
        <?php if ($post['picture'] != ''): ?>
            <img src='<?php echo $post['picture']; ?>'/>
        <?php endif; ?>
        <!-- display tweet -->
        <p><?php echo $post['tweet']; ?></p>
        <!-- favorite button -->
        <?php if (!fetch_record($check_faves . $post['id'])): ?>
            <button id='<?php echo "fav_button" . $post['id'];?>' onclick=<?php echo "favorite(" . $post['id'] . "," . $post['userid'] . ")";?>>Add to favorites</button>
        <?php endif;?> 
    <?php endforeach; ?>



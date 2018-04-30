<div class='user_and_tweet'>
    <img src=<?php if (isset($post['profile_pic'])) {echo $post['profile_pic'];} else {echo 'http://4.bp.blogspot.com/-zsbDeAUd8aY/US7F0ta5d9I/AAAAAAAAEKY/UL2AAhHj6J8/s1600/facebook-default-no-profile-pic.jpg';}; ?>>
    <div class='username'>
        <a href="#" onclick=<?php echo "showUserTweets(" . $post['userid'] .")";?>><?php echo '@' . $post['username']; ?></a><br>
        <span><?php echo $post['firstname'] . ' ' . $post['lastname']; ?></span>
    </div>
</div>

<?php if ($post['picture'] != ''): ?>
    <img onclick=<?php echo 'showTweet(' . $post['id'] . ')';?> src='<?php echo $post['picture']; ?>'/>
<?php endif; ?>
<!-- display tweet -->
<p onclick=<?php echo 'showTweet(' . $post['id'] . ')';?>><?php echo $post['tweet']; ?></p>
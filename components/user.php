<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel='stylesheet' type='text/css' href='styles/femke_styles.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>



<div class='user_and_tweet'>
<a onclick=<?php echo "showUserTweets(" . $post['userid'] .")";?>>
    <img class='tweet-userimg' src=<?php if (isset($post['profile_pic'])) {echo $post['profile_pic'];} else {echo 'http://4.bp.blogspot.com/-zsbDeAUd8aY/US7F0ta5d9I/AAAAAAAAEKY/UL2AAhHj6J8/s1600/facebook-default-no-profile-pic.jpg';}; ?>>
</a>
<div class='user-info'>
    <a onclick=<?php echo "showUserTweets(" . $post['userid'] .")";?>>
        <span><?php echo $post['firstname'] . ' ' . $post['lastname']; ?></span><br>
    </a>
    <a onclick=<?php echo "showUserTweets(" . $post['userid'] .")";?>>
        <?php echo '@' . $post['username']; ?>
    </a>
    </div>
</div>
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

</body>

</html>
<!DOCTYPE html>
<html>

<head>

    <style>
        .tweet-userimg {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            float: left;
            box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: inline-block;
            margin-left: 10px;
        }

        .user-info span {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .user-info a {
            font-size: .8rem;
            color: #717171;
            font-weight: 300;
            text-decoration: none;
        }

        .tweet__content {
            padding-top: 15px;
            text-align: left;
            font-weight: 300;
            color: #717171;
        }

        .tweet__content::before {
            display: block;
            content: '';
            width: 100%;
            height: 1px;
            background-color: #f4f4f4;
            margin-bottom: 8px;
        }   

        .tweet__content::after {
            display: block;
            content: '';
            width: 100%;
            height: 1px;
            background-color: #f4f4f4;
            margin-bottom: 8px;
        }   

        #created_at {
            font-size: 0.7rem;
            float: right;
            color: #717171;
        }

        .tweet-img {
            width: 100%;
            box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>



<div class='user_and_tweet'>
<a href="#" onclick=<?php echo "showUserTweets(" . $post['userid'] .")";?>>
    <img class='tweet-userimg' src=<?php if (isset($post['profile_pic'])) {echo $post['profile_pic'];} else {echo 'http://4.bp.blogspot.com/-zsbDeAUd8aY/US7F0ta5d9I/AAAAAAAAEKY/UL2AAhHj6J8/s1600/facebook-default-no-profile-pic.jpg';}; ?>>
</a>
<div class='user-info'>
    <a href="#" onclick=<?php echo "showUserTweets(" . $post['userid'] .")";?>>
        <span><?php echo $post['firstname'] . ' ' . $post['lastname']; ?></span><br>
    </a>
    <a href="#" onclick=<?php echo "showUserTweets(" . $post['userid'] .")";?>>
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
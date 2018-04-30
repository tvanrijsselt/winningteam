<!-- create reply -->
<form target='_self' action='process_reply.php' method='POST'>
    Reply: <textarea type="text" name='content' maxlength='280'></textarea><br>
    Photo: <input type='url' name='picture'></input>
    <input type='hidden' name='tweet_id' value=<?php echo $_POST['id'];?>>
    <input id="post_reply" type='submit' value='Post reply!'></input>
</form>
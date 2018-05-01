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
      $post = fetch_record($select_tweets . ' WHERE tweets.id = ' . $_POST['id']);?>
<?php include('user.php'); ?>

<!-- create reply -->
<form target='_self' action='process_reply.php' method='POST'>
    Reply: <textarea type="text" name='content' maxlength='280'></textarea><br>
    Photo: <input id='photo' type='url' name='picture'></input>
    <input type='hidden' name='tweet_id' value=<?php echo $_POST['id'];?>>
    <input id="post_reply" type='submit' value='Post reply!'></input>
</form>


</body>

</html>
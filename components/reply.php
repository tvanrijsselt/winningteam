<!DOCTYPE html>

<html>

<head>
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

    <style>
        form {
            font-family: 'Poppins', sans-serif;
            color: #717171;
        }

        textarea {
            width: 100%;
            font-family: 'Poppins', sans-serif;
            color: #717171;
            border: 1px solid #E9EBEE;
            box-shadow: 0 2px 2px 0px rgba(0, 0, 0, 0.1);
        }

        #photo {
            width: 50%;
            font-family: 'Poppins', sans-serif;
            color: #717171;
            border: 1px solid #E9EBEE;
            box-shadow: 0 2px 2px 0px rgba(0, 0, 0, 0.1);
        }

        #post_reply {
            padding: 5px 10px;
            font-family: 'Poppins', sans-serif;
            font-size: .7rem;
            border-radius: 2px;
            border: 1px solid transparent;
            background-color: #f6f7f9;
            border: 1px solid #DADFE2;
            color: #4B4F56;
            cursor: pointer;
            box-shadow: 0 0px 5px 0px rgba(0, 0, 0, 0.1);
            float: right; 
        }

        #post_reply:hover {
            background-color: #E9EBEE;
        }
    </style>
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
<!DOCTYPE html>

<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        #favorite, #unfavorite {
            padding: 5px 10px;
            font-family: 'Poppins', sans-serif;
            border-radius: 2px;
            border: none;
            background-color: white;
            color: #4B4F56;
            cursor: pointer;
        }
        #favorite:hover {
            background-color: #E9EBEE;
        }
        #unfavorite:hover {
            background-color: #E9EBEE;
        }
    </style>

</head>

<body>

<?php if (!fetch_record($check_faves . $post['id'])): ?>
    <button id='favorite' onclick=<?php echo "favorite(" . $post['id'] . "," . $post['userid'] . ")";?>>
        <i class="fa fa-heart-o"></i> Favorite
    </button>
<?php else: ?>
    <button id='unfavorite' onclick=<?php echo "unfavorite(" . $post['id'] . ")";?>>
        <i class="fa fa-check"></i> Unfavorite
    </button>
<?php endif;?>

</body>

</html>
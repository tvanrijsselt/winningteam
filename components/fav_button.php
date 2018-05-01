<!DOCTYPE html>

<html>

<head>
    <link rel='stylesheet' type='text/css' href='styles/femke_styles.css' />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
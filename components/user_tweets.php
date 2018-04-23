<?php require_once('../connect.php');?>
<?php include_once('../queries.php');?>

<?php
$user_tweets = fetch_all($select_tweets . ' WHERE user_id =' . $_POST['id']);


foreach ($user_tweets as $post): ?>
    <div class='tweet'>
        <!-- display user -->
        <p><?php echo $post['firstname'] . ' ' . $post['lastname']; ?></p>
        <!-- only display picture if one has been uploaded -->
        <?php if ($post['picture'] != ''): ?>
            <img src='<?php echo $post['picture']; ?>'/>
        <?php endif; ?>
        <!-- display tweet -->
        <p><?php echo $post['tweet']; ?></p>
        <!-- favorite button -->
        <button id='favorite' onclick=<?php echo "favorite(" . $post['id'] . ")";?>>Add to favorites</button>
    </div>
<?php endforeach; ?>
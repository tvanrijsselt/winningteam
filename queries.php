<?php

require_once('connect.php');

echo $_POST['tweet_id'];
echo $_POST['user_id'];

$select_tweets = 'SELECT tweet, picture, tweets.id AS id, users.id AS userid, firstname, lastname FROM users JOIN tweets ON users.id=tweets.user_id';

// select all tweets
$tweets = fetch_all($select_tweets);

// select favorite tweets
$faves = fetch_all('SELECT 
    tweet, picture, firstname, lastname, tweets.id AS id
    FROM faves
    JOIN tweets
    ON tweets.id = faves.tweet_id
    JOIN users
    ON users.id = faves.users_id
    WHERE users.id = 1' // append logged in user_id
);
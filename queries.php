<?php

require_once('connect.php');

$select_tweets = 'SELECT tweet, picture, tweets.id AS id, users.id AS userid, firstname, lastname 
    FROM users JOIN tweets ON users.id=tweets.user_id';

// select all tweets
$tweets = fetch_all($select_tweets . ' ORDER BY tweets.id DESC');

// select favorite tweets
// to: change faves.user_id to logged in user id
$faves = fetch_all('SELECT 
    tweet, picture, firstname, lastname, tweets.id AS id
    FROM faves
    JOIN tweets
    ON tweets.id = faves.tweet_id
    JOIN users
    ON users.id = tweets.user_id
    WHERE faves.user_id = 1
    ORDER BY faves.id DESC'     
);

// check if tweet is in faves
// to do: change user_id to logged in user id
$check_faves = 'SELECT * FROM faves WHERE user_id = 1 AND tweet_id =';

// tweets of people that are followed by user
// to do: -change follower_id to logged in user id
//        -order by tweet.created_at independent of user
$followings = fetch_all('SELECT tweet, picture, firstname, lastname FROM followings 
    JOIN users ON users.id = followings.user_id 
    JOIN tweets ON tweets.user_id = users.id 
    WHERE follower_id = 1');

$check_followings = 'SELECT * FROM followings WHERE follower_id = 1 AND user_id =';
<?php

require_once('connect.php');
session_start();
$userid = $_SESSION['user-id'];

$user_logged_in = fetch_record(
"SELECT firstname, lastname FROM users WHERE users.id = $userid");

$select_tweets = 'SELECT tweet, picture, tweets.id AS id, users.id AS userid, firstname, lastname, profile_pic, username, bio, tweets.created_at AS created_at 
    FROM users JOIN tweets ON users.id=tweets.user_id';

// select all tweets
$tweets = fetch_all($select_tweets . ' ORDER BY tweets.id DESC');

// select favorite tweets
// to: change faves.user_id to logged in user id
$faves = fetch_all($select_tweets . 
    " JOIN faves
    ON tweets.id = faves.tweet_id
    WHERE faves.user_id = $userid
    ORDER BY faves.id DESC"     
);

// check if tweet is in faves
// to do: change user_id to logged in user id
$check_faves = "SELECT * FROM faves WHERE faves.user_id = $userid AND faves.tweet_id =";

// tweets of people that are followed by user
// to do: -change follower_id to logged in user id
//        -order by tweet.created_at independent of user
$followings = fetch_all($select_tweets .
    " JOIN followings ON users.id = followings.user_id 
    WHERE follower_id = $userid ORDER BY tweets.id DESC");

$check_followings = "SELECT * FROM followings WHERE follower_id = $userid AND followings.user_id =";

$replies = 'SELECT content, replies.picture AS picture, username, firstname, lastname, profile_pic, users.id AS userid, replies.created_at AS created_at 
    FROM replies JOIN tweets ON tweets.id = replies.tweet_id JOIN users ON users.id = replies.user_id WHERE tweets.id = ';
<?php

require "./module/sk_twitter/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

function tweet($tweet, $image) {
  global $tw_app, $user;

  $conn = new TwitterOAuth(
    $tw_app['key'],
    $tw_app['secret'],
    $user['oauth_token'],
    $user['oauth_token_secret']
  );

  $media = $conn->upload(
    'media/upload',
    ['media' => localTwitterMedia($image)]
  );

  $parameters = [
    'status' => $tweet,
    'media_ids' => implode(',', [$media->media_id_string])
  ];

  $result = $conn->post('statuses/update', $parameters);

  if (isset($result->errors)) {
    preprint($result);
    die;
  }

  return true;
}

function localTwitterMedia($image) {
  $img = "./module/sk_twitter/twitter.jpg";
  copy($image, $img);
  return $img;
}


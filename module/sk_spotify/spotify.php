<?php


function getUserPlaylists($user_spotify_id) {
  $user_playlist_details = [];

  $curl_url = "https://api.spotify.com/v1/users/" . $user_spotify_id . "/playlists?limit=50";

  $j = 1;

  $ch = curl_init();
  do {
    $curl_result = curl_get($ch, $curl_url);
    $obj = json_decode($curl_result, true);
    foreach ($obj['items'] as $v) {
      $array['No'] = $j;
      $array['url'] = $v['external_urls']['spotify'];
      $array['id'] = $v['id'];
      $array['name'] = $v['name'];
      $user_playlist_details[] = $array;
      $j++;
    }
    $curl_url = $obj['next'];
  } while ($curl_url != "");
  curl_close ($ch);

  return $user_playlist_details;
}


function deleteTrackFromPlaylist($track_id, $playlist_id) {
  $curl_url = "https://api.spotify.com/v1/users/1231619190/playlists/" . $playlist_id . "/tracks";
  $playlist_track[] = $track_id;
  $curl_field = createCurlField($playlist_track, 'delete');
  $ch = curl_init();
  $curl_result = curl_delete($ch, $curl_url, $curl_field);
  curl_close($ch);
}


function new_accesstoken($refresh_token) {
  global $client_id, $client_secret;

  $api_url = 'https://accounts.spotify.com/api/token';

  $auth = base64_encode("$client_id:$client_secret");

  $header = [
    "Authorization: Basic $auth",
    'Content-type: application/x-www-form-urlencoded',
  ];

  $data = [
    'grant_type' => 'refresh_token',
    'refresh_token' => $refresh_token,
  ];
  $data = http_build_query($data);

  $http = [
    'method' => 'POST',
    'header' => $header,
    'content' => $data,
  ];

  $options = [
    'http' => $http,
  ];

  $context = stream_context_create($options);

  $obj_result = file_get_contents($api_url, false, $context);
  $obj = json_decode($obj_result);

  return $obj->{'access_token'};
}


function ch_exec($ch, $cUrl, $cMethod, $cField) {
  global $spotifyAccessToken;

  curl_setopt($ch, CURLOPT_HTTPGET, 1); // https://stackoverflow.com/questions/24251782/unset-curl-curlopt-postfields
  curl_setopt($ch, CURLOPT_URL, $cUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  if ($cField) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $cField);
  }
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $cMethod);

  $headers[] = "Accept: application/json";
  $headers[] = "Authorization: Bearer " . $spotifyAccessToken;
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  if (curl_errno($ch)) echo 'Error:' . curl_error($ch);
  return curl_exec($ch);
}

function curl_post($ch, $curl_url, $curl_field) {
  return ch_exec($ch, $curl_url, 'POST', $curl_field);
}

function curl_delete($ch, $curl_url, $curl_field) {
  return ch_exec($ch, $curl_url, 'DELETE', $curl_field);
}

function curl_put($ch, $curl_url, $curl_field) {
  return ch_exec($ch, $curl_url, 'PUT', $curl_field);
}

function curl_get($ch, $curl_url){
  return ch_exec($ch, $curl_url, 'GET', false);
}


function createCurlFieldPlaylist($name, $description) {
  return "{
    \"name\":\"" . $name . "\",
    \"description\":\"" . $description . "\"
  }";
}

function createCurlField($spotify_code, $action, $first = false) {
  $beginning = "{\"uris\": [\"spotify:track:";
  $adding = ",\"spotify:track:";
  $ending = "]}";

  if ($first) {
    $ending = "], \"position\": 0}";
  }

  if ($action === 'delete') {
    $beginning = "{\"tracks\":[{\"uri\":\"spotify:track:";
    $adding = "},{\"uri\":\"spotify:track:";
    $ending = "}]}";
  }

  $curl_field = $beginning . $spotify_code[0] . "\"";
  if (count($spotify_code) > 1) {
    for ($i = 1; $i < count($spotify_code); $i++) {
      $curl_field .= $adding . $spotify_code[$i] . "\"";
    }
  }
  $curl_field .= $ending;
  return $curl_field;
}


<?php

$api_url = 'https://api.dc01.gamelockerapp.com/shards/';
$api_key = 'YOUR-APIKEY';

$headers = array(
  'Accept: application/json',
  'X-TITLE-ID: semc-vainglory',
  'Authorization: Bearer ' . $api_key,
);

$options = array('http' => array(
  'method' => 'GET',
  'header' => implode("\r\n", $headers),
));

function getSinglePlayer ($player_region, $player_id) {
  global $api_url, $headers, $options;
  $prefix = 'players';
  $player_query = array(
    'id' => $player_id,
    'region' => $player_region,
  );
  $player_request_uri = $api_url . $player_query['region'] . '/' . $prefix . '/' . $player_query['id'];
  if ($player_return_obj = file_get_contents($player_request_uri, false, stream_context_create($options))) {
    $player_arr = json_decode($player_return_obj, true);
    return $player_arr;
  }
}

function getPlayers ($player_region, $player_name) {
  global $api_url, $headers, $options;
  $prefix = 'players';
  $player_query = array(
    'region' => $player_region,
    'player_name' => $player_name,
    'filter' => 'filter[playerNames]=' . $player_name,
  );
  $player_request_uri = $api_url . $player_query['region'] . '/' . $prefix . '?' . $player_query['filter'];
  if ($player_return_obj = file_get_contents($player_request_uri, false, stream_context_create($options))) {
    $player_arr = json_decode($player_return_obj, true);
    return $player_arr;
  }
}

function getMatches ($matches_region, $matches_player_name, $matches_count) {
  if (!is_admin()) {
    global $api_url, $headers, $options;
    $prefix = 'matches';
    $matches_query = array(
      'region' => $matches_region,
      'sort' => 'sort=-createdAt',
      'filter' => 'filter[playerNames]=' . $matches_player_name . '&filter[createdAt-start]=2017-02-14T00:00:00Z&filter[gameMode]=',
      'per_page' => 'page[limit]=' . $matches_count,
    );

    $matches_request_uri = $api_url . $matches_query['region'] . '/' . $prefix . '/?' . $matches_query['sort'] . '&' . $matches_query['filter'] . '&' . $matches_query['per_page'];
    if ($matches_return_obj = file_get_contents($matches_request_uri, false, stream_context_create($options))) {
      $matches_arr = json_decode($matches_return_obj, true);
      return $matches_arr;
    }
  }
}
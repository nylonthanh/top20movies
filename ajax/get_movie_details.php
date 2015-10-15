<?php

//@todo: signature logic and test
const ALLOW_ACCESS = true;
require_once __DIR__ . '/../App/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

$movieId = filter_var($_REQUEST['movieId'], FILTER_SANITIZE_STRING);
$param = 'api_key=' . MOVIEDB_API_KEY;
$movieList = [];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://api.themoviedb.org/3/movie/$movieId?$param");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$movieData = curl_exec($ch);
curl_close($ch);

if ($movieData === false) {
    http_response_code(400);

}

http_response_code(200);
//header('Content-Type: application/json');
//echo $movieData;

$partial = new \App\View('movie-details.html');
$partial->render(json_decode($movieData));

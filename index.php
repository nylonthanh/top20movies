<?php

const ALLOW_ACCESS = true;

$loader = require_once __DIR__ . '/vendor/autoload.php';

// Serve from the cache if it is younger than $cachetime

$cache = new \App\CachingHelper();

if ($cache->isCached()) {
    $movieList = json_decode(file_get_contents($cache->getCache()));

} else {
    try {
        $movieListObj = new App\MovieHelper('2015-01-01', 'revenue.desc', 1);
        $movieListObj->setMovieList();
        $movieListObj->updateRevenueMovieList();
        $movieList = $movieListObj->getMovieList();

        $cache->updateCache($movieList);

    } catch (Exception $e) {
        //assumes mail will work
        error_log($e->getMessage());
        mail(ADMIN_EMAIL, 'Exception thrown', $e->getMessage());
        echo 'sorry could not connect to the Movie DB Serverice.';

    }
}

try {
    (new App\View('index.html'))->render($movieList);

} catch (Exception $e) {
    (new app\view('error.html'))->render($e->getMessage());

}

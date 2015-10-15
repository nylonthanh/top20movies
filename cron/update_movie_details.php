<?php
error_reporting(-1);
    print(PHP_EOL . 'update movie information is starting...' . PHP_EOL);

    const ALLOW_ACCESS = true;
    $loader = require_once __DIR__ . '/../vendor/autoload.php';
    $cache = new \App\CachingHelper();

    try {
        $movieListObj = new App\MovieHelper('2015-01-01', 'revenue.desc', 1);
        print('calling movie service...' . PHP_EOL);
        $movieListObj->setMovieList();

        print('updating movie list with revenue and additional info...' . PHP_EOL);
        $movieListObj->updateRevenueMovieList();

        $movieList = $movieListObj->getMovieList();

        print('updating the cache file...' . PHP_EOL);

        $cache->updateCache($movieList);
        print('finished updating the cache file!' . PHP_EOL);

    } catch (Exception $e) {
        //assumes mail will work
        error_log($e->getMessage());
        mail(ADMIN_EMAIL, 'Exception thrown', $e->getMessage());
        print('sorry could not connect to the Movie DB Serverice. Error: ' . $e->getMessage(). PHP_EOL);

    }


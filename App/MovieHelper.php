<?php

namespace App;

if(!defined('ALLOW_ACCESS')) {
    die('Direct access not permitted');
}

require_once __DIR__ . '/config.php';

class MovieHelper
{
    public $movieList;
    public $releaseDateGte;
    public $sortBy;
    public $pageNumber;

    public function __construct($releaseDateGte = null, $sortBy = null, $pageNumber = null)
    {
        $this->pageNumber = $pageNumber ?: 1;
        $this->releaseDateGte = $releaseDateGte ?: '2015-01-01';
        $this->sortBy = $sortBy ?: 'revenue.desc';
        $this->movieList = null;

    }

    /**
     * calls themoviedb api and returns top 20 grossing movies of 2015
     * //https://api.themoviedb.org/3/discover/movie?api_key=9e1b08f9af16f8d7c20c0dd0aeb4749a&sort_by=revenue.desc&page=1&primary_release_date.gte=2015-01-01
     * @return mixed
     */
    public function setMovieList()
    {
        $params = http_build_query(array(
            "page" => $this->pageNumber,
            "primary_release_date.gte" => $this->releaseDateGte,
            "sort_by" => $this->sortyBy,
            "api_key" => MOVIEDB_API_KEY
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, MOVIEDB_API_URL . "/discover/movie?" . $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        try {
            $response = curl_exec($ch);
        } catch (\Exception $e) {
            echo $e->getMessage();die;
        }

        curl_close($ch);

        if (empty($response) || !isset($response)) {
            throw new \Exception('getMovieList could not retrieve any movies. Please check your parameters.');
        }

        $this->movieList = json_decode($response)->results;

        return true;

    }

    /**
     * add revenue to movie list
     * @param null $movies
     * @return array
     * @throws \Exception
     */
    public function updateRevenueMovieList()
    {
        if ($this->movieList === null) {
            throw new \Exception('setMovieList() missing correct param / type. Check movieList. Type: array. ');

        }

        //get revenue
        //$id is from the top 20 list
        $param = 'api_key=' . MOVIEDB_API_KEY;
        $movieList = [];

        foreach($this->movieList as $movie => $movieDataObj){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://api.themoviedb.org/3/movie/$movieDataObj->id?$param");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            $movieData = curl_exec($ch);
            curl_close($ch);

            $movieList = $this->addRevenue($movieDataObj, $movieData, $movieList);

        }

        if (empty($movieList) || !isset($movieList)) {
            throw new \Exception(__FUNCTION__ . ' returned an empty result. Please check the parameters.');

        }

        $this->movieList = $movieList;

        return true;

    }

    /**
     * @param $movieDataObj
     * @param $movieData
     * @param $movieList
     * @return array
     */
    protected function addRevenue($movieDataObj, $movieData, $movieList)
    {
        $movieList[] = array(
            'title' => $movieDataObj->title,
            'vote_average' => $movieDataObj->vote_average,
            'vote_count' => $movieDataObj->vote_count,
            'revenue' => json_decode($movieData)->revenue,
            'overview' => $movieDataObj->overview,
            'poster_path' => $movieDataObj->poster_path
        );

        return $movieList;

    }

    public function getMovieList()
    {
        return $this->movieList;

    }

}
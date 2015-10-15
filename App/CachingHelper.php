<?php

namespace App;

if(!defined('ALLOW_ACCESS')) {
    die('Direct access not permitted');
}

require_once __DIR__ . '/config.php';


class CachingHelper
{
    protected $cacheFile;
    protected $cacheTime;

    public function __construct()
    {
        $this->cacheFile = CACHE_FILE;
        $this->cacheTime = CACHE_TIME;

    }

    /**
     * writes the movie list to cache
     * @param $cacheFile
     * @param $content
     */
    public function updateCache(Array $content)
    {
        // open the cache file for writing
        $fp = fopen($this->cacheFile, 'w');
        fwrite($fp, json_encode($content));
        fclose($fp);

    }

    /**
     * @param $cachefile
     * @param $cachetime
     * @return bool
     */
    public function isCached()
    {
        return file_exists($this->cacheFile) && (time() - $this->cacheTime < filemtime($this->cacheFile));

    }

    public function getCache()
    {
        return $this->cacheFile;

    }

}



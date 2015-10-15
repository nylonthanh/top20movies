<?php

namespace App;

if(!defined('ALLOW_ACCESS')) {
    die('Direct access not permitted');
}

class View
{
    public $loader;
    public $twig;
    public $template;

    public function __construct($template = 'index.html')
    {
        $this->loader = new \Twig_Loader_Filesystem(__DIR__ . '/../templates');
        $this->twig = new \Twig_Environment($this->loader, array(
            'debug' => true,
            'cache' => __DIR__ . '/../cache'
        ));
        $this->twig->addExtension(new \Twig_Extension_Debug());
        $this->template = $this->twig->loadTemplate($template);

    }

    /**
     * @param null $movieList
     * @throws \Exception
     */
    public function render($movieList = null)
    {
        if ($movieList === null) {
            throw new \Exception('movieList is null.');

        }

        echo $this->template->render(array(
            'movieArray' => $movieList
        ));

    }

}




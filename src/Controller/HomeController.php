<?php

namespace Pecheocoup\Controller;

use Silex\Application;

class HomeController{
    function indexAction(Application $app){
        return $app['twig']->render( "layout.html",array(
            'title' => "accueil",
            )
        );
    }

}

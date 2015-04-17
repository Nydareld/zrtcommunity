<?php

namespace Pecheocoup\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class HomeController{

    public function indexAction(Application $app){
        return $app['twig']->render( "layout.html",array(
            'title' => "accueil",
            )
        );
    }

    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
            'title' => "login",
            ));
    }

}

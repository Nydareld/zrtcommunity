<?php

namespace Pecheocoup\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class HomeController{

    public function indexAction(Application $app){
        return $app['twig']->render( "home.html",array(
            'title' => "accueil",
            )
        );
    }

    public function loginAction(Request $request, Application $app, $success=null) {
        return $app['twig']->render('login.html', array(
            'danger'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
            'title' => "login",
            'success'=>$success,
            ));
    }

    public function usersAction

}

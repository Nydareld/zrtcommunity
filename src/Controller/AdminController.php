<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Silex\Application;
use \DateTime;

class AdminController{
    public function adminAction(Request $request, Application $app){
        return $app['twig']->render( "admin-Layout.html",array(
            'panelname' => 'statistiques',
            )
        );
    }
}

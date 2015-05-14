<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Zrtcommunity\Domain\News;
use Zrtcommunity\Form\Type\NewsType;
use \DateTime;

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
    public function notifAction($notifid,$notifpath,Request $request, Application $app){
        $notif = $app['dao.notification']->loadNotifById($notifid);
        if(isset($notif)){
            if($notif->getUser() == $app['security']->getToken()->getUser() ){
                $app['dao.notification']->remove($notif);
                return $app->redirect($request->getBasePath().'/'.$notifpath);
            }else{
                throw new \Exception("Cette notification n'existe pas ou ne vous est pas déstinée");
            }
        }else{
            return $app->redirect($request->getBasePath().'/'.$notifpath);
        }
    }

}

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
            'section'=>"default",
            'title' => "accueil",
            )
        );
    }

    public function pdcAction(Application $app){
        return $app['twig']->render( "pdc.html",array(
            'section'=>"default",
            'title' => "PDC",
            )
        );
    }

    public function cguAction(Application $app){
        return $app['twig']->render( "cgu.html",array(
            'section'=>"default",
            'title' => "CGU",
            )
        );
    }

    public function presentationAction($sectionName,Application $app){
        $section = $app['dao.section']->loadByName($sectionName);

        return $app['twig']->render( "home-".$section->getName().".html",array(
            'title' => "présentaton",
            'section'=>$section->getName(),
            )
        );
    }

    public function loginAction(Request $request, Application $app, $success=null) {
        return $app['twig']->render('login.html', array(
            'section'=>"default",
            'danger'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
            'title' => "login",
            'success'=>$success,
            ));
    }
    public function notifAction($notifid,$notifpath,Request $request, Application $app){
        $notif = $app['dao.notification']->loadNotifById($notifid);
        $path = str_replace('.','/',$notifpath);
        if(isset($notif)){
            if($notif->getUser() == $app['security']->getToken()->getUser() ){
                $app['dao.notification']->remove($notif);
                return $app->redirect($request->getBasePath().'/'.$path);
            }else{
                throw new \Exception("Cette notification n'existe pas ou ne vous est pas déstinée");
            }
        }else{
            return $app->redirect($request->getBasePath().'/'.$path);
        }
    }

    public function regleAction(Request $request, Application $app){
        $reglement = $app['dao.regle']->loadRegleById(1);
        return $app['twig']->render( "reglement.html",array(
            'title' => "Reglement",
            'reglement' => $reglement
            )
        );
    }

}

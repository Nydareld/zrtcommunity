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

    public function addNewsAction(Request $request, Application $app){
        $news = new News();

        $newsForm = $app['form.factory']->create(new NewsType(), $news);
        $newsForm->handleRequest($request);
        if ( $newsForm->isSubmitted()&& $newsForm->isValid()) {
            $user= $app['security']->getToken()->getUser();
            $news->setCreator($user);
            $news->setDate(new DateTime());

            $app['dao.news']->save($news);

            return $app->redirect($request->getBasePath().'/news/'.$news->getId());
        }
        return $app['twig']->render( "basicForm.html",array(
            'title' => "Nouvelle news",
            'form' => $newsForm->createView(),
            )
        );
    }



}

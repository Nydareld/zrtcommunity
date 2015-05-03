<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Zrtcommunity\Domain\News;
use Zrtcommunity\Form\Type\NewsType;
use Zrtcommunity\Domain\MessageNews;
use Zrtcommunity\Form\Type\MessageType;

use \DateTime;

class NewsController{

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
            'editor' => 'ckeditor-full',
            )
        );
    }

    public function newsAction(Request $request, Application $app){
        $news = $app['dao.news']->loadAllNews();

        usort($news ,function ($a, $b){
            if ( $a->getDate() == $b->getDate() ) {
                return 0;
            }
            return ($a->getDate() < $b->getDate() ) ? -1 : 1;
        });

        return $app['twig']->render( "news.html",array(
            'title' => "News",
            'news' => $news,
            )
        );
    }

    public function uneNewsAction($newsid,Request $request, Application $app){
        $news = $app['dao.news']->loadNewsById($newsid);

        $messages = $news->getMessages()->getValues();

        usort($messages ,function ($a, $b){
            if ( $a->getDate() == $b->getDate() ) {
                return 0;
            }
            return ($a->getDate() < $b->getDate() ) ? -1 : 1;
        });
        $news->setMessages($messages);

        $message = new MessageNews();

        $messageForm = $app['form.factory']->create(new MessageType(), $message);
        $messageForm->handleRequest($request);
        if ($messageForm->isSubmitted() && $messageForm->isValid()&& $app['security']->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $message->setDate(new DateTime());
            $token = $app['security']->getToken();
            $message->setAuteur($token->getUser());
            $message->setNews($news);
            $app['dao.messNews']->save($message);

            return $app->redirect($request->getBasePath().'/news/'.$news->getId());
        }
        return $app['twig']->render( "unenews.html",array(
            'title' => "News",
            'news' => $news,
            'postForm' => $messageForm->createView(),
            )
        );
    }



}

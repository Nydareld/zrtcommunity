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

    public function addNewsAction($sectionName,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);

        $news = new News();

        $user= $app['security']->getToken()->getUser();

        if( !$section->getAdmins()->contains($user) && ! $section->getModos()->contains($user) ){
            throw new \Exception("l'ajout de news est réservé a la modération");
        }

        $newsForm = $app['form.factory']->create(new NewsType(), $news);
        $newsForm->handleRequest($request);
        if ( $newsForm->isSubmitted()&& $newsForm->isValid()) {
            $user= $app['security']->getToken()->getUser();
            $news->setCreator($user);
            $news->setDate(new DateTime());
            $news->setSectionSite($section);

            $app['dao.news']->save($news);

            return $app->redirect($request->getBasePath().'/'.$section->getName().'/news/'.$news->getId());
        }
        return $app['twig']->render( "basicForm.html",array(
            'section'=>$section->getName(),
            'title' => "Nouvelle news",
            'form' => $newsForm->createView(),
            'editor' => 'ckeditor-full',
            )
        );
    }

    public function newsAction($sectionName,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);

        $news = $app['dao.news']->loadAllNewsBySection($section);

        $modo=false;

        $user = $app['security']->getToken()->getUser();

        if( $section->getAdmins()->contains($user) || $section->getModos()->contains($user)){
            $modo = true;
        }


        usort($news ,function ($a, $b){
            if ( $a->getDate() == $b->getDate() ) {
                return 0;
            }
            return ($a->getDate() < $b->getDate() ) ? -1 : 1;
        });

        return $app['twig']->render( "news.html",array(
            'section'=>$section->getName(),
            'title' => "News",
            'news' => $news,
            'modo' => $modo
            )
        );
    }

    public function uneNewsAction($sectionName,$newsid,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);
        $news = $app['dao.news']->loadNewsById($newsid);

        $modo=false;

        $user = $app['security']->getToken()->getUser();

        if( $section->getAdmins()->contains($user) || $section->getModos()->contains($user) || $app['security']->isGranted('ROLE_ADMIN') ){
            $modo = true;
        }

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

            return $app->redirect($request->getBasePath().'/'.$section->getName().'/news/'.$news->getId());
        }
        return $app['twig']->render( "unenews.html",array(
            'section'=>$section->getName(),
            'title' => "News",
            'news' => $news,
            'postForm' => $messageForm->createView(),
            "modo" => $modo,
            )
        );
    }

    public function editMessageAction($sectionName,$messageid,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);
        $message = $app['dao.messNews']->loadMessageById($messageid);
        $messageForm = $app['form.factory']->create(new MessageType(), $message);
        $messageForm->handleRequest($request);
        if ($messageForm->isSubmitted() && $messageForm->isValid() && $app['security']->isGranted('IS_AUTHENTICATED_FULLY')) {
            $app['dao.messNews']->save($message);
            return $app->redirect($request->getBasePath().'/'.$section->getName().'/news/'.$message->getNews()->getId());
        }
        return $app['twig']->render( "basicForm.html",array(
            'section'=>$section->getName(),
            'title' => "News",
            'form' => $messageForm->createView(),
            )
        );
    }

    public function delNewsAction($sectionName,$newsid,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);
        $news = $app['dao.news']->loadNewsById($newsid);

        $user = $app['security']->getToken()->getUser();

        if( ! ($section->getAdmins()->contains($user) || $section->getModos()->contains($user) || $app['security']->isGranted('ROLE_ADMIN') )){
            throw new \Exception("Seuls les modos et admin de section peuvent supprimer une news");
        }
        $app['dao.news']->remove($news);
        return $app->redirect($request->getBasePath().'/'.$news->getSectionSite()->getName().'/news');

    }

    public function editNewsAction($sectionName,$newsid,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);
        $news = $app['dao.news']->loadNewsById($newsid);

        $user = $app['security']->getToken()->getUser();

        if( ! ($section->getAdmins()->contains($user) || $section->getModos()->contains($user) || $app['security']->isGranted('ROLE_ADMIN') )){
            throw new \Exception("Seuls les modos et admin de section peuvent editier une news");
        }

        $newsForm = $app['form.factory']->create(new NewsType(), $news);
        $newsForm->handleRequest($request);
        if ( $newsForm->isSubmitted()&& $newsForm->isValid()) {

            $app['dao.news']->save($news);

            return $app->redirect($request->getBasePath().'/'.$section->getName().'/news/'.$news->getId());
        }
        return $app['twig']->render( "basicForm.html",array(
            'section'=>$section->getName(),
            'title' => "Nouvelle news",
            'form' => $newsForm->createView(),
            'editor' => 'ckeditor-full',
            )
        );
    }



}

<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Silex\Application;
use Zrtcommunity\Domain\Topic;
use Zrtcommunity\Form\Type\TopicType;
use Zrtcommunity\Form\Type\MoveTopicType;
use Zrtcommunity\Domain\MessageForum;
use Zrtcommunity\Form\Type\MessageType;
use Zrtcommunity\Domain\Notification;

use \DateTime;

class ForumController{

    public function forumAction($sectionName, Request $request, Application $app){
        //$sectionName = "zrtcraft";
        $section = $app['dao.section']->loadByName($sectionName);
        $categories = $app['dao.categorie']->loadAllCategorieBySection($section);

        return $app['twig']->render( "forum.html",array(
            'section'=>$section->getName(),
            'title' => "Forum",
            'categories' => $categories,
            )
        );
    }

    public function scatAction($sectionName,$scatid,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);

        $scat = $app['dao.scat']->loadSousCategorieById($scatid);

        $topics = $scat->getTopics()->getValues();

        usort($topics ,function ($a, $b){
            if ( $a->lastMessage()->getDate() == $b->lastMessage()->getDate() ) {
                return 0;
            }
            return ($a->lastMessage()->getDate() > $b->lastMessage()->getDate() ) ? -1 : 1;
        });
        $scat->setTopics($topics);

        if( $scat->getAdmin() && !$app['security']->isGranted('ROLE_MODO') ){
            throw new \Exception("vous ne pouvez pas acceder aux discussions admin");
        }

        return $app['twig']->render( "sousCategorie.html",array(
            'section'=>$section->getName(),
            'title' => "Forum",
            'scat' => $scat,
            )
        );
    }

    public function topicAction($sectionName,$topicid,$page,Request $request, Application $app){

        $section = $app['dao.section']->loadByName($sectionName);

        $topic = $app['dao.topic']->loadTopicById($topicid);

        if( $topic->getSousCategorie()->getAdmin() && !$app['security']->isGranted('ROLE_MODO') ){
            throw new \Exception("vous ne pouvez pas acceder aux discussions admin");
        }

        $messages = $topic->getMessages()->getValues();

        usort($messages ,function ($a, $b){
            if ( $a->getDate() == $b->getDate() ) {
                return 0;
            }
            return ($a->getDate() < $b->getDate() ) ? -1 : 1;
        });

        if ($page=="last") {
            if(floor(count($messages)/10) != count($messages)/10){
                $page=floor(count($messages)/10);
            }else{
                $page=floor(count($messages)/10)-1;
            }
        }

        $nbpages=floor(count($messages)/10);

        $topic->setMessages(array_slice($messages,$page*10,10));

        $message = new MessageForum();

        $messageForm = $app['form.factory']->create(new MessageType(), $message);
        $messageForm->handleRequest($request);
        if ($messageForm->isSubmitted() && $messageForm->isValid()&& $app['security']->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $message->setDate(new DateTime());
            $token = $app['security']->getToken();
            $message->setAuteur($token->getUser());
            $message->setTopic($topic);
            $app['dao.messForum']->save($message);

            foreach ($topic->getMessages() as $message ) {
                $userNotif = $message->getAuteur();
                $pathNotif = $request->getBasePath().'/forum.topic.'.$topic->getId();
                if ($userNotif->getNotifRepForum() && !$app['dao.notification']->existPathUser($pathNotif,$userNotif) && $userNotif != $token->getUser() ){

                    $notif = new Notification();
                    $notif->setMessage("Nouvelle réponse au sujet \"".$topic->getName()."\"");
                    $notif->setPath($pathNotif);
                    $notif->setUser($userNotif);

                    $app['dao.notification']->save($notif);
                }
            }

            return $app->redirect($request->getBasePath().'/'.$section->getName().'/forum/topic/'.$topic->getId()."/last");

        }
        return $app['twig']->render( "topic.html",array(
            'section'=>$section->getName(),
            'title' => "Forum",
            'topic' => $topic,
            'postForm' => $messageForm->createView(),
            'page'=> $page+1,
            'nbpages'=> $nbpages+1
            )
        );
    }

    public function editMessageAction($sectionName,$messageid,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);

        $message = $app['dao.messForum']->loadMessageById($messageid);
        $messageForm = $app['form.factory']->create(new MessageType(), $message);
        $messageForm->handleRequest($request);
        if($app['security']->getToken()->getUser()!=$message->getAuteur()){
            throw new \Exception("vous ne pouvez pas editer le message d'un autre membre");
        }
        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $app['dao.messForum']->save($message);
            return $app->redirect($request->getBasePath().'/'.$section->getName().'/forum/topic/'.$message->getTopic()->getId()."/last");
        }
        return $app['twig']->render( "basicForm.html",array(
            'section'=>$section->getName(),
            'title' => "Forum",
            'form' => $messageForm->createView(),
            )
        );
    }

    public function addtopicAction($sectionName,$scatid,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);

        $topic = new Topic();
        $message = new MessageForum();

        $topicForm = $app['form.factory']->create(new TopicType(), $topic);
        $topicForm->handleRequest($request);

        if( $app['dao.scat']->loadSousCategorieById($scatid)->getAdmin() && !$app['security']->isGranted('ROLE_MODO') ){
            throw new \Exception("vous ne pouvez pas acceder aux discussions admin");
        }

        if ( $topicForm->isSubmitted()&& $topicForm->isValid()) {
            $user= $app['security']->getToken()->getUser();
            $topic->setCreator($user);
            $topic->setSousCategorie($app['dao.scat']->loadSousCategorieById($scatid));

            $message->setAuteur($user);
            $message->setDate(new DateTime());
            $message->setTopic($topic);
            $message->setContenu($topicForm["contenu"]->getData());

            $app['dao.topic']->save($topic);
            $app['dao.messForum']->save($message);

            return $app->redirect($request->getBasePath().'/'.$section->getName().'/forum/topic/'.$topic->getId()."/last");
        }
        return $app['twig']->render( "basicForm.html",array(
            'section'=>$section->getName(),
            'title' => "Forum",
            'form' => $topicForm->createView(),
            )
        );

    }
    public function moveTopicAction($sectionName,$topicid,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionName);

        $topic = $app['dao.topic']->loadTopicById($topicid);

        $moveTopicForm = $app['form.factory']->create(new MoveTopicType());

        return $app['twig']->render( "basicForm.html",array(
            'section'=>$section->getName(),
            'title' => "Forum",
            'form' => $moveTopicForm->createView(),
            )
        );

    }
}

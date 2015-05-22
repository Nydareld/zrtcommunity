<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Silex\Application;
use Zrtcommunity\Domain\Topic;
use Zrtcommunity\Form\Type\TopicType;
use Zrtcommunity\Domain\MessageForum;
use Zrtcommunity\Form\Type\MessageType;
use \DateTime;

class ForumController{

    public function forumAction(Request $request, Application $app){
        $categories = $app['dao.categorie']->loadAllCategories();

        return $app['twig']->render( "forum.html",array(
            'title' => "Forum",
            'categories' => $categories,
            )
        );
    }

    public function scatAction($scatid,Request $request, Application $app){
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
            'title' => "Forum",
            'scat' => $scat,
            )
        );
    }

    public function topicAction($topicid,Request $request, Application $app){
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
        $topic->setMessages($messages);

        $message = new MessageForum();

        $messageForm = $app['form.factory']->create(new MessageType(), $message);
        $messageForm->handleRequest($request);
        if ($messageForm->isSubmitted() && $messageForm->isValid()&& $app['security']->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $message->setDate(new DateTime());
            $token = $app['security']->getToken();
            $message->setAuteur($token->getUser());
            $message->setTopic($topic);
            $app['dao.messForum']->save($message);

            return $app->redirect($request->getBasePath().'/forum/topic/'.$topic->getId());

        }
        return $app['twig']->render( "topic.html",array(
            'title' => "Forum",
            'topic' => $topic,
            'postForm' => $messageForm->createView(),
            )
        );
    }

    public function editMessageAction($messageid,Request $request, Application $app){
        $message = $app['dao.messForum']->loadMessageById($messageid);
        $messageForm = $app['form.factory']->create(new MessageType(), $message);
        $messageForm->handleRequest($request);
        if ($messageForm->isSubmitted() && $messageForm->isValid() && $app['security']->isGranted('IS_AUTHENTICATED_FULLY')) {
            $app['dao.messForum']->save($message);
            return $app->redirect($request->getBasePath().'/forum/topic/'.$message->getTopic()->getId());
        }
        return $app['twig']->render( "basicForm.html",array(
            'title' => "Forum",
            'form' => $messageForm->createView(),
            )
        );
    }

    public function addtopicAction($scatid,Request $request, Application $app){
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

            return $app->redirect($request->getBasePath().'/forum/topic/'.$topic->getId());
        }
        return $app['twig']->render( "basicForm.html",array(
            'title' => "Forum",
            'form' => $topicForm->createView(),
            )
        );

    }
}

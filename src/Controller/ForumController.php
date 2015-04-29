<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

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
        return $app['twig']->render( "sousCategorie.html",array(
            'title' => "Forum",
            'scat' => $scat,
            )
        );
    }

    public function topicAction($topicid,Request $request, Application $app){
        $topic = $app['dao.topic']->loadTopicById($topicid);

        $messages = $topic->getMessages()->getValues();

        usort($messages ,function ($a, $b){
            if ( $a->getDate() == $b->getDate() ) {
                return 0;
            }
            return ($a->getDate() < $b->getDate() ) ? -1 : 1;
        });
        $topic->setMessages($messages);
        return $app['twig']->render( "topic.html",array(
            'title' => "Forum",
            'topic' => $topic,
            )
        );
    }
}

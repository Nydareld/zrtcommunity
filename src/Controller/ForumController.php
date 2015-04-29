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

        return $app['twig']->render( "sousCategorie.html",array(
            'title' => "Forum",
            'scat' => $scat,
            )
        );
    }
}

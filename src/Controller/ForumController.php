<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class ForumController{

    public function categorieAction($categoriename,Request $request, Application $app){
        $categorie = $app['dao.categorie']->loadCategorieByName($categoriename);

        return $app['twig']->render( "forum.html",array(
            'title' => "Forum",
            'categorie' => $categorie,
            )
        );
    }

}

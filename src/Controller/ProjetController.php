<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use Zrtcommunity\Domain\Projet;
use Zrtcommunity\Form\Type\ProjetType;
use Zrtcommunity\Domain\MembreProjet;
use \DateTime;

class ProjetController{
    public function addProjectAction(Request $request, Application $app){
        $projet = new Projet();

        $projetForm = $app['form.factory']->create(new ProjetType(), $projet);
        $projetForm->handleRequest($request);

        if( $projetForm->isSubmitted()&& $projetForm->isValid()){
            // id nom desc region
            $projet->setDate(new DateTime());
            $projet->setAccepted(FALSE);
            $projet->setFinished(FALSE);
            $projet->setRegion($app['dao.region']->loadRegionById($projetForm["region"]->getData()));

            $membre = new MembreProjet();
            $membre->setOwner(TRUE);
            $membre->setAlias("Chef de projet");
            $membre->setUser($app['security']->getToken()->getUser());
            $membre->setProjet($projet);

            $app['dao.projet']->save($projet);
            $app['dao.membreProjet']->save($membre);

            return $app->redirect($request->getBasePath().'/projet/'.$projet->getId());
        }
        return $app['twig']->render( "basicForm.html",array(
            'title' => "Nouveau projet",
            'form' => $projetForm->createView(),
        ));
    }
    public function projectAction(Request $request, Application $app){
        $projets = $app['dao.projet']->loadAllProjet();

        usort($projets ,function ($a, $b){
            if ( $a->getDate() == $b->getDate() ) {
                return 0;
            }
            return ($a->getDate() < $b->getDate() ) ? -1 : 1;
        });

        return $app['twig']->render( "projet.html",array(
            'title' => "Projets",
            'projets' => $projets,
            )
        );

    }
}

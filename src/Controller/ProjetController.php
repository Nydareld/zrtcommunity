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
            $projet->setCreateur($app['security']->getToken()->getUser());

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
    public function regionsAction(Request $request, Application $app){
        $regions = $app['dao.region']->loadAllRegion();
        return $app['twig']->render( "region.html",array(
            'title' => "Regions",
            'regions' => $regions,
            )
        );

    }
    public function unProjetAction($projetid, Request $request, Application $app){
        $projet = $app['dao.projet']->loadProjetById($projetid);
        return $app['twig']->render( "unProjet.html",array(
            'title' => "Projet",
            'projet' => $projet,
            )
        );
    }
    public function uneRegionAction($regionid, Request $request, Application $app){
        $region = $app['dao.region']->loadRegionById($regionid);
        return $app['twig']->render( "uneRegion.html",array(
            'title' => "Region",
            'region' => $region,
            )
        );
    }
}

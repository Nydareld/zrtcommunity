<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use Zrtcommunity\Domain\Projet;
use Zrtcommunity\Domain\MessagePrive;
use Zrtcommunity\Form\Type\ProjetType;
use Zrtcommunity\Form\Type\EditProjetType;
use Zrtcommunity\Form\Type\ValidProjetType;
use Zrtcommunity\Form\Type\MPSansTitreType;
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

    public function editProjectAction($idprojet, Request $request, Application $app){
        $projet = $app['dao.projet']->loadProjetById($idprojet);

        $projetForm = $app['form.factory']->create(new EditProjetType(), $projet);
        $projetForm->handleRequest($request);

        if( $projetForm->isSubmitted()&& $projetForm->isValid() && $projet->getCreateur() == $app['security']->getToken()->getUser()){

            $app['dao.projet']->save($projet);

            return $app->redirect($request->getBasePath().'/projet/'.$projet->getId());
        }
        return $app['twig']->render( "basicForm.html",array(
            'title' => "Modification projet",
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
    public function validProjetAction($projetid, $decision, Request $request, Application $app){
        $projet = $app['dao.projet']->loadProjetById($projetid);
        if($decision == 'validate'){
            $projetForm = $app['form.factory']->create(new ValidProjetType(), $projet);
            $projetForm->handleRequest($request);
            if( $projetForm->isSubmitted()&& $projetForm->isValid()){
                $projet->setAccepted(true);
                $mp = new MessagePrive();
                $mp->setAuteur($app['security']->getToken()->getUser());
                $mp->setDestinataire($projet->getCreateur());
                $mp->setDate(new DateTime());
                $mp->setLu(false);
                $mp->setTitre("Votre projet intitulé \"".$projet->getName()."\" à été validé par la modération");
                $mp->setContenu("positions du cubo de votre projet: <br/>X=".$projet->getLocalisationX()."<br/>Z=".$projet->getLocalisationY());
                $app['dao.messPrive']->save($mp);
                $app['dao.projet']->save($projet);
                return $app->redirect($request->getBasePath().'/projet/'.$projet->getId());
            }
            return $app['twig']->render('acceptProjetForm.html', array(
                'title' => "Validation projet",
                "form" => $projetForm->createView(),
            ));
        }else{
            $mp = new MessagePrive();

            $messageForm = $app['form.factory']->create(new MPSansTitreType(), $mp);
            $messageForm->handleRequest($request);

            if ($messageForm->isSubmitted() && $messageForm->isValid() ) {
                $mp->setAuteur($app['security']->getToken()->getUser());
                $mp->setDestinataire($projet->getCreateur());
                $mp->setDate(new DateTime());
                $mp->setLu(false);
                $mp->setTitre("Votre projet intitulé \"".$projet->getName()."\" à été refusé par la modération");
                $app['dao.messPrive']->save($mp);
                $app['dao.projet']->remove($projet);
                return $app->redirect($request->getBasePath().'/messagerie/message/'.$mp->getId());
            }
            return $app['twig']->render('refusProjetForm.html', array(
                'title' => "Refus projet",
                "form" => $messageForm->createView(),
            ));
        }
    }

}

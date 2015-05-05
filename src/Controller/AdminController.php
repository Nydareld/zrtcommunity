<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Silex\Application;
use Zrtcommunity\Domain\Region;
use Zrtcommunity\Form\Type\RegionType;
use \DateTime;

class AdminController{
    public function adminAction(Request $request, Application $app){

        $days = array();
        for ($i = 0; $i < 30; $i++) {
            $days[] = new DateTime(date('Y-m-d',strtotime('-'.$i.'days')));
        }
        $days=array_reverse($days);

        $visits=$app['dao.visit']->findAll();

        $nbVisitsUser=array();
        $nbVisitsGuest=array();

        for($i =0; $i<count($days);$i++){
            $nbVisitsUser[$i]=$app['dao.visit']->findUserVisitByDay($days[$i]);
            $nbVisitsGuest[$i]=$app['dao.visit']->findGuestVisitByDay($days[$i]);
        }

        $navigators=$app['dao.visit']->findVisitByNavigator();
        $devices=$app['dao.visit']->findVisitByDevice();

        return $app['twig']->render( "admin-stat.html",array(
            'panelname' => 'Statistiques',
            'visitsUser' => $nbVisitsUser,
            'visitsGuest' => $nbVisitsGuest,
            'days'=>$days,
            'navigators' => $navigators,
            'devices' => $devices,
            )
        );
    }

    public function regionProjetAction(Request $request, Application $app){
        $region = new Region();

        $regionForm = $app['form.factory']->create(new RegionType(), $region);
        $regionForm->handleRequest($request);
        if( $regionForm->isSubmitted()&& $regionForm->isValid()){
            $app['dao.region']->save($region);
            return $app->redirect($request->getBasePath().'/admin/regionprojet');
        }
        return $app['twig']->render( "adminRegionProjet.html",array(
            'panelname' => "Régions et projets",
            'form' => $regionForm->createView(),
            )
        );
    }

}

<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Silex\Application;
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


        return $app['twig']->render( "admin-stat.html",array(
            'panelname' => 'statistiques',
            'visitsUser' => $nbVisitsUser,
            'visitsGuest' => $nbVisitsGuest,
            'days'=>$days,
            )
        );
    }
}

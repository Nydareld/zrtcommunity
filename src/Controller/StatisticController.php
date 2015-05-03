<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Zrtcommunity\Domain\Visit;
use Zrtcommunity\Domain\VisitActionPath;
use \DateTime;

class StatisticController{
    public static function registerStatisticVisit(){
        global $app;
        $path=$app['request']->getPathInfo();
        //verifier si la requete est la suite d'une visite en cours
        $ip = $_SERVER["REMOTE_ADDR"];
        $date = new DateTime();
        if($app['dao.visit']->loadCurrentVisit($ip, $date) !== null){
            $visit = $app['dao.visit']->loadCurrentVisit($ip, $date);
        }else{
            $visit = new Visit();

            $visit->setIp($ip);
            $visit->setDate($date);

            $app['dao.visit']->save($visit);
        }
        if($app['security']->isGranted('IS_AUTHENTICATED_FULLY')){
            $visit->setVisitor($token = $app['security']->getToken()->getUser());
            $app['dao.visit']->save($visit);
        }
        $vap=new VisitActionPath();
        $vap->setDate(new DateTime());
        $vap->setVisit($visit);
        $vap->setPath($path);
        $app['dao.visitActionPath']->save($vap);
    }
}

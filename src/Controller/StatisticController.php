<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Zrtcommunity\Domain\Visit;
use Zrtcommunity\Domain\VisitActionPath;
use \DateTime;

class StatisticController{

    public static function registerStatistic(){
        StatisticController::registerStatisticVisit();
    }

    private static function registerStatisticVisit(){
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
        $visit->setNavigator(StatisticController::registerStatisticNavigator());
        $visit->setDevice(StatisticController::registerStatisticDevice());
        $vap=new VisitActionPath();
        $vap->setDate(new DateTime());
        $vap->setVisit($visit);
        $vap->setPath($path);
        $app['dao.visitActionPath']->save($vap);
    }

    private static function registerStatisticNavigator(){
        if (preg_match_all("#Opera (.*)(\[[a-z]{2}\];)?$#isU", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'Opéra';}
        elseif (preg_match_all("#MSIE (.*);#isU", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'Internet Explorer';}
        elseif (preg_match_all("#Firefox(.*)$#isU", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'Firefox';}
        elseif (preg_match_all("#Chrome(.*) Safari#isU", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'Chrome';}
        elseif (preg_match_all("#Opera(.*) \(#isU", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'Opéra' . $version;}
        elseif (preg_match("#Nokia#", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'Nokia';}
        elseif (preg_match("#Safari#", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'Safari';}
        elseif (preg_match("#SeaMonkey#", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'SeaMonkey';}
        elseif (preg_match("#PSP#", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'PSP';}
        elseif (preg_match("#Netscape#", $_SERVER["HTTP_USER_AGENT"])){
        	$navigateur = 'Netscape';}
        else{
        	$navigateur = 'Inconnu';}
        return $navigateur;
    }

    private static function registerStatisticDevice(){
        global $app;
        if($app["mobile_detect"]->isMobile() && !$app["mobile_detect"]->isTablet()){
        	$device = 'Téléphone';
        }elseif ($app["mobile_detect"]->isTablet()){
            $device = 'Tablette';
        }else{
            $device = 'Ordinateur';
        }
        //detect tablet
        //detect phone
        //detect desctop
        return $device;
    }
}

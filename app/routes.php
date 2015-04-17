<?php

/*
Page d'accueil
*/
$app->get('/',"Pecheocoup\Controller\HomeController::indexAction");

$app->get('/login',"Pecheocoup\Controller\HomeController::loginAction")->bind('login');

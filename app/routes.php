<?php

//Page d'accueil
$app->get('/',"Pecheocoup\Controller\HomeController::indexAction");

//Page de connexion
$app->get('/login',"Pecheocoup\Controller\HomeController::loginAction")->bind('login');

//Page d'inscription
$app->match('/inscription', "Pecheocoup\Controller\UserController::addUserAction")->bind('inscription');

//liste des membres
$app->match('/membres', "Pecheocoup\Controller\UserController::usersAction");

<?php

//Page d'accueil
$app->get('/',"Zrtcommunity\Controller\HomeController::indexAction");

//Page de connexion
$app->get('/login',"Zrtcommunity\Controller\HomeController::loginAction")->bind('login');

//Page d'inscription
$app->match('/inscription', "Zrtcommunity\Controller\UserController::addUserAction")->bind('inscription');

//liste des membres
$app->get('/membres', "Zrtcommunity\Controller\UserController::usersAction");

//Info d'un membere
$app->match('/membre/{username}', "Zrtcommunity\Controller\UserController::userProfileAction");

//forum page d'une catégorie
$app->match('/forum', "Zrtcommunity\Controller\ForumController::forumAction");

$app->match('/forum/souscategorie/{scatid}', "Zrtcommunity\Controller\ForumController::scatAction");

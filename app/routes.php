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

//forum page d'accueil
$app->match('/forum', "Zrtcommunity\Controller\ForumController::forumAction");

//Forum page de sous catégorie
$app->match('/forum/souscategorie/{scatid}', "Zrtcommunity\Controller\ForumController::scatAction");

//Forum page d'un topic
$app->match('/forum/topic/{topicid}', "Zrtcommunity\Controller\ForumController::topicAction");

//Forum page d'édition d'un message forum
$app->match('/forum/editmessage/{messageid}', "Zrtcommunity\Controller\ForumController::editMessageAction");

//Forum page d'ajout de topic
$app->match('/forum/souscategorie/newtopic/{scatid}', "Zrtcommunity\Controller\ForumController::addtopicAction");

//News page des news
$app->match('/news', "Zrtcommunity\Controller\NewsController::newsAction");

//News page d'une news
$app->match('/news/{newsid}', "Zrtcommunity\Controller\NewsController::uneNewsAction");

//News page d'ajout de news
$app->match('/newnews', "Zrtcommunity\Controller\NewsController::addNewsAction");

//News page d'édition d'un message news
$app->match('/news/editmessage/{messageid}', "Zrtcommunity\Controller\NewsController::editMessageAction");

//Admin page d'accueil du panel
$app->match('/admin',"Zrtcommunity\Controller\AdminController::adminAction");


//Admin page d'accueil du panel
$app->match('/admin/regionprojet',"Zrtcommunity\Controller\AdminController::regionProjetAction");

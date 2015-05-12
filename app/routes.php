<?php

//Page d'accueil
$app->get('/',"Zrtcommunity\Controller\HomeController::indexAction");

//Page de connexion
$app->get('/login',"Zrtcommunity\Controller\HomeController::loginAction")->bind('login');

//Page d'inscription
$app->match('/inscription', "Zrtcommunity\Controller\UserController::addUserAction")->bind('inscription');

//Membres liste des membres
$app->get('/membres', "Zrtcommunity\Controller\UserController::usersAction");

//Membres Info d'un membere
$app->match('/membre/{username}', "Zrtcommunity\Controller\UserController::userProfileAction");

//Membre edit de sois. /member/edit
$app->match('/member/edit', "Zrtcommunity\Controller\UserController::editProfileAction");

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

//Admin page des projets et régions
$app->match('/admin/regionprojet',"Zrtcommunity\Controller\AdminController::regionProjetAction");

//Projet page d'accueil des projets
$app->match('/projet', "Zrtcommunity\Controller\ProjetController::projectAction");

//Projet page d'ajout de projet
$app->match('/projet/newprojet', "Zrtcommunity\Controller\ProjetController::addProjectAction");

//Projet page d'ajout de projet
$app->match('/projet/editprojet/{idprojet}', "Zrtcommunity\Controller\ProjetController::editProjectAction");

//Projet page des régions
$app->match('/projet/regions', "Zrtcommunity\Controller\ProjetController::regionsAction");

//Projet page des régions
$app->match('/projet/region/{regionid}', "Zrtcommunity\Controller\ProjetController::uneRegionAction");

//Projet page des régions
$app->match('/projet/{projetid}', "Zrtcommunity\Controller\ProjetController::unProjetAction");

//Messagerie messages recus
$app->match('/messagerie/inbox', "Zrtcommunity\Controller\MPController::inboxAction");

//Messagerie messages envoyés
$app->match('/messagerie/outbox', "Zrtcommunity\Controller\MPController::outboxAction");

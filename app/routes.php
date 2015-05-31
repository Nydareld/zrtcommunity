<?php
//Admin page d'accueil du panel
$app->match('/admin',"Zrtcommunity\Controller\AdminController::adminAction");

//Admin page d'administration des regles
$app->match('/admin/reglement',"Zrtcommunity\Controller\AdminController::reglementAction");

//Admin page de supression d'une regles
$app->match('/admin/reglement/del/{regleId}',"Zrtcommunity\Controller\AdminController::reglementDelAction");

//Admin page de modification d'une regles
$app->match('/admin/reglement/modify/{regleId}',"Zrtcommunity\Controller\AdminController::reglementModifyAction");

//Admin page d'ajout d'une regles
$app->match('/admin/reglement/add/{regleId}',"Zrtcommunity\Controller\AdminController::reglementAddAction");

//Admin page des projets et régions
$app->match('/admin/regionprojet',"Zrtcommunity\Controller\AdminController::regionProjetAction");

//Admin page de création de catégorie, sous catégorie
$app->match('/admin/{sectionId}/forum',"Zrtcommunity\Controller\AdminController::forumAction");

//Admin page de la liste du staff
$app->match('/admin/{sectionId}/staff',"Zrtcommunity\Controller\AdminController::staffAction");

//Admin page d'un persone du staff
$app->match('/admin/{sectionId}/staff/{userid}',"Zrtcommunity\Controller\AdminController::staffUserAction");

//Admin page d'un persone du staff
$app->match('/admin/{sectionId}/staff/{userid}/modRole',"Zrtcommunity\Controller\AdminController::staffUserModAction");

//Admin page d'un persone du staff
$app->match('/admin/{sectionId}/staff/{userid}/delRole',"Zrtcommunity\Controller\AdminController::staffUserDelAction");

//Admin page de création de questionaire
$app->match('/admin/questionaire',"Zrtcommunity\Controller\AdminController::questionaireAction");

//Admin page de redirection de validation de questionaire
$app->match('/admin/questionaire/validate/{questionaireId}/{choice}',"Zrtcommunity\Controller\AdminController::validateQuestionaireRedirectionAction");

//Admin page de redirection de validation de questionaire
$app->match('/admin/users/list',"Zrtcommunity\Controller\AdminController::userListAction");

//Admin page de redirection de validation de questionaire
$app->match('/admin/users/{userid}',"Zrtcommunity\Controller\AdminController::userModAction");

//Admin route pour choisir un model
$app->match('/admin/questionaire/choose/{idModel}',"Zrtcommunity\Controller\AdminController::chooseQuestionaireAction");

//Admin route supression catégorie
$app->match('/admin/forum/categorie/delete/{idCat}',"Zrtcommunity\Controller\AdminController::delCatAction");

//Admin route supression scat
$app->match('/admin/forum/souscategorie/delete/{idSCat}',"Zrtcommunity\Controller\AdminController::delScatAction");

//Page d'accueil
$app->get('/',"Zrtcommunity\Controller\HomeController::indexAction");

//pdc
$app->get('/pdc',"Zrtcommunity\Controller\HomeController::pdcAction");

//Page présebtation
$app->get('/{sectionName}/presentation',"Zrtcommunity\Controller\HomeController::presentationAction");

//page du reglement
$app->match('/reglement', "Zrtcommunity\Controller\HomeController::regleAction");

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

//Membre remplir questionaire
$app->match('/member/questionaire', "Zrtcommunity\Controller\UserController::questionnaireProfileAction");

//forum page d'accueil
$app->match('/{sectionName}/forum', "Zrtcommunity\Controller\ForumController::forumAction");

//Forum page de sous catégorie
$app->match('/{sectionName}/forum/souscategorie/{scatid}', "Zrtcommunity\Controller\ForumController::scatAction");

//Forum page d'un topic
$app->match('/{sectionName}/forum/topic/{topicid}/{page}', "Zrtcommunity\Controller\ForumController::topicAction");

//Forum page move un topic
$app->match('/{sectionName}/forum/movetopic/{topicid}', "Zrtcommunity\Controller\ForumController::moveTopicAction");

//Forum close d'un topic
$app->match('/{sectionName}/forum/closetopic/{topicid}', "Zrtcommunity\Controller\ForumController::closeTopicAction");

//Forum page d'édition d'un message forum
$app->match('/{sectionName}/forum/editmessage/{messageid}', "Zrtcommunity\Controller\ForumController::editMessageAction");

//Forum page d'ajout de topic
$app->match('/{sectionName}/forum/souscategorie/newtopic/{scatid}', "Zrtcommunity\Controller\ForumController::addtopicAction");

//News page des news
$app->match('/{sectionName}/news', "Zrtcommunity\Controller\NewsController::newsAction");

//News page d'une news
$app->match('/{sectionName}/news/{newsid}', "Zrtcommunity\Controller\NewsController::uneNewsAction");

//News page d'ajout de news
$app->match('/{sectionName}/newnews', "Zrtcommunity\Controller\NewsController::addNewsAction");

//News page d'édition d'un message news
$app->match('/{sectionName}/news/editmessage/{messageid}', "Zrtcommunity\Controller\NewsController::editMessageAction");


//Projet page d'accueil des projets
$app->match('/projet', "Zrtcommunity\Controller\ProjetController::projectAction");

//Projet page d'ajout de projet
$app->match('/projet/newprojet', "Zrtcommunity\Controller\ProjetController::addProjectAction");

//Projet page d'edition de projet
$app->match('/projet/editprojet/{idprojet}', "Zrtcommunity\Controller\ProjetController::editProjectAction");

//Projet page des régions
$app->match('/projet/regions', "Zrtcommunity\Controller\ProjetController::regionsAction");

//Projet page d'une région
$app->match('/projet/region/{regionid}', "Zrtcommunity\Controller\ProjetController::uneRegionAction");

//Projet page d'un projets
$app->match('/projet/{projetid}', "Zrtcommunity\Controller\ProjetController::unProjetAction");

//Projet page de validation d'un projets
$app->match('/projet/validate/{projetid}/{decision}', "Zrtcommunity\Controller\ProjetController::validProjetAction");

//Messagerie messages recus
$app->match('/messagerie/inbox', "Zrtcommunity\Controller\MPController::inboxAction");

//Messagerie messages envoyés
$app->match('/messagerie/outbox', "Zrtcommunity\Controller\MPController::outboxAction");

//Messagerie un message
$app->match('/messagerie/message/{messageid}', "Zrtcommunity\Controller\MPController::unMessageAction");

//Messagerie nouveau message
$app->match('/messagerie/newmp/{userid}', "Zrtcommunity\Controller\MPController::newMessageAction");

//Notification
$app->match('/notification/{notifid}/{notifpath}', "Zrtcommunity\Controller\HomeController::notifAction");

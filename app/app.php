<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();


//  === twig ===
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

//  === doctrine orm ===
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/Domain"), $app['debug']);
$app['orm.em'] = EntityManager::create($app['db.options'], $config);

//  === symfony security ===
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new Zrtcommunity\DAO\UserDAO($app['orm.em']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_MODO'),
        'ROLE_MODO' => array('ROLE_TARD'),
        'ROLE_TARD' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_MODO'),
        array('^/forum/souscategorie/newtopic', 'ROLE_USER'),
        array('^/forum/editmessage', 'ROLE_USER'),
        array('^/newnews', 'ROLE_MODO'),
        array('^/news/editmessage', 'ROLE_USER'),
        array('^/projet/newprojet', 'ROLE_TARD'),
        array('^/messagerie', 'ROLE_USER'),
        array('^/projet/validate/', 'ROLE_MODO'),
        array('^/admin/forum/categorie/delete', 'ROLE_ADMIN'),
        array('^/admin/forum/souscategorie/delete', 'ROLE_ADMIN'),
        array('^//admin/reglement/add', 'ROLE_ADMIN'),
    ),
));

//  === is Mobile ===

use Binfo\Silex\MobileDetectServiceProvider;
$app->register(new MobileDetectServiceProvider());

//  === symfony monolog ===
/*
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/Zrtcommunity.log',
    'monolog.name' => 'Zrtcommunity',
    'monolog.level' => $app['monolog.level']
));
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
if (isset($app['debug']) && $app['debug']) {
    $app->register(new Silex\Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__.'/../var/cache/profiler'
    ));
}
*/
//  === symfony form ===
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

//  === dao User ===
$app['dao.user'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\UserDAO($app['orm.em']);
});

//  === dao Categorie ===
$app['dao.categorie'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\CategorieDAO($app['orm.em']);
});

//  === dao sous Categorie ===
$app['dao.scat'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\SousCategorieDAO($app['orm.em']);
});

//  === dao Topic ===
$app['dao.topic'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\TopicDAO($app['orm.em']);
});

//  === dao News ===
$app['dao.news'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\NewsDAO($app['orm.em']);
});

//  === dao MessageForum ===
$app['dao.messForum'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\MessageForumDAO($app['orm.em']);
});

//  === dao MessageNews ===
$app['dao.messNews'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\MessageNewsDAO($app['orm.em']);
});

//  === dao Messageprivé ===
$app['dao.messPrive'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\MessagePriveDAO($app['orm.em']);
});

//  === dao Visit ===
$app['dao.visit'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\VisitDAO($app['orm.em']);
});

//  === dao VisitActionPath ===
$app['dao.visitActionPath'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\VisitActionPathDAO($app['orm.em']);
});

//  === dao Region ===
$app['dao.region'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\RegionDAO($app['orm.em']);
});

//  === dao Projet ===
$app['dao.projet'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\ProjetDAO($app['orm.em']);
});

//  === dao MembreProjet ===
$app['dao.membreProjet'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\MembreProjetDAO($app['orm.em']);
});

//  === dao Notification ===
$app['dao.notification'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\NotificationDAO($app['orm.em']);
});

//  === dao ModelQuestionaire ===
$app['dao.modelQuestionaire'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\ModelQuestionaireDAO($app['orm.em']);
});

//  === dao Question ===
$app['dao.question'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\QuestionDAO($app['orm.em']);
});

//  === dao Questionaire ===
$app['dao.questionaire'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\QuestionaireDAO($app['orm.em']);
});

//  === dao Questionaire ===
$app['dao.regle'] = $app->share(function ($app) {
    return new Zrtcommunity\DAO\RegleDAO($app['orm.em']);
});

//  === Home controller ===
$app['Home.controller'] = $app->share(function ($app) {
    return new Zrtcommunity\Controller\HomeController();
});

//  === Forum controller ===
$app['Forum.controller'] = $app->share(function ($app) {
    return new Zrtcommunity\Controller\ForumController();
});

//  === Statistic controller ===
$app['Stat.controller'] = $app->share(function ($app) {
    return new Zrtcommunity\Controller\StatisticController();
});

//  === app info ===
$app['info'] = $app->share(function ($app){
    return new Zrtcommunity\Domain\Info();
});

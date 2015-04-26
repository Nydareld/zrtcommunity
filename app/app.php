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
));

//  === symfony monolog ===
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

//  === Home controller ===
$app['Home.controller'] = $app->share(function ($app) {
    return new Zrtcommunity\Controller\HomeController();
});

//  === app info ===
$app['info'] = $app->share(function ($app){
    return new Zrtcommunity\Domain\Info();
});

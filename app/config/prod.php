<?php


$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'localhost',
    'dbname'   => 'pecheocoup',
    'user'     => 'pecheocoup_user',
    'password' => 'secret',
);

$app['monolog.level'] = 'WARNING';

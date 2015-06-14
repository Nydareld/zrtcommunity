<?php

date_default_timezone_set ("Europe/Paris");

require __DIR__.'/bootstrap.php';

$app->before('Zrtcommunity\Controller\StatisticController::registerStatistic');

$app->run();

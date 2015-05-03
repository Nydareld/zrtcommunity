<?php

require __DIR__.'/bootstrap.php';

$app->before('Zrtcommunity\Controller\StatisticController::registerStatisticVisit');

$app->run();

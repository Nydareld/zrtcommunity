<?php

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;

<?php

$app['monolog.level'] = 'INFO';

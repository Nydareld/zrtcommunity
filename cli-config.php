<?php
// cli-config.php
require_once "web/bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app['orm.em']);

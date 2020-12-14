<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../conf/credentials.php';
require __DIR__ . '/../libs/Facebook/autoload.php';

require __DIR__ . '/../store/generated-conf/config.php';

session_set_cookie_params(3600,"/");
session_start();

$app = new \Slim\App(["settings" => $config]);

include __DIR__ . '/../conf/configuration.php';

include __DIR__ . '/../conf/routes.php';


$app->run();

?>
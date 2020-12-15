<?php

$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("logs/app.log");
    $logger->pushHandler($file_handler);
    
    $queryLogger =  new \Monolog\Logger('defaultLogger');
    $queryLogger->pushHandler(new \Monolog\Handler\StreamHandler('logs/propel.log'));
    \Propel\Runtime\Propel::getServiceContainer()->setLogger('defaultLogger', $queryLogger);
    \Propel\Runtime\Propel::getConnection()->useDebug(true);
    return $logger;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates/', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    //$view->getExtension('Twig_Extension_Core')->setTimezone('Europe/Italy');
    return $view;
};

$container['notFoundHandler'] = function ($c) {
	return function ($request, $response) use ($c) {
		return $c->view->render($response, 'common/404.html')
		->withStatus(404)
		->withHeader('Content-Type', 'text/html', ['user' => $_SESSION['loggedUser']]);
	};
};

$container['LoginController'] = function ($app2) use ($app) {
    return new Montanari\Controllers\LoginController($app2);
};

$container['EventController'] = function ($app2) use ($app) {
    return new Montanari\Controllers\EventController($app2);
};

$container['ProfileController'] = function ($app2) use ($app) {
	return new Montanari\Controllers\ProfileController($app2);
};

$container['CronController'] = function ($app2) use ($app) {
	return new Montanari\Controllers\CronController($app2);
};

$container['SettingController'] = function ($app2) use ($app) {
	return new Montanari\Controllers\SettingController($app2);
};

$container['DriverController'] = function ($app2) use ($app) {
	return new Montanari\Controllers\DriverController($app2);
};

$container['PassengerController'] = function ($app2) use ($app) {
	return new Montanari\Controllers\PassengerController($app2);
};

$container['AjaxController'] = function ($app2) use ($app) {
	return new Montanari\Controllers\AjaxController($app2);
};

$container['MessageController'] = function ($app2) use ($app) {
	return new Montanari\Controllers\MessageController($app2);
};

$container['NotificationController'] = function ($app2) use ($app) {
	return new Montanari\Controllers\NotificationController($app2);
};
?>
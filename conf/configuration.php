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

$container['LoginController'] = function ($app) use ($app) {
    return new Montanari\Controllers\LoginController($app);
};

$container['EventController'] = function ($app) use ($app) {
    return new Montanari\Controllers\EventController($app);
};

$container['ProfileController'] = function ($app) use ($app) {
	return new Montanari\Controllers\ProfileController($app);
};

$container['CronController'] = function ($app) use ($app) {
	return new Montanari\Controllers\CronController($app);
};

$container['SettingController'] = function ($app) use ($app) {
	return new Montanari\Controllers\SettingController($app);
};

$container['DriverController'] = function ($app) use ($app) {
	return new Montanari\Controllers\DriverController($app);
};

$container['PassengerController'] = function ($app) use ($app) {
	return new Montanari\Controllers\PassengerController($app);
};

$container['AjaxController'] = function ($app) use ($app) {
	return new Montanari\Controllers\AjaxController($app);
};

$container['MessageController'] = function ($app) use ($app) {
	return new Montanari\Controllers\MessageController($app);
};

$container['NotificationController'] = function ($app) use ($app) {
	return new Montanari\Controllers\NotificationController($app);
};
?>
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

$container['LoginController'] = function ($container2) use ($container) {
    return new Montanari\Controllers\LoginController($container2);
};

$container['EventController'] = function ($container2) use ($container) {
    return new Montanari\Controllers\EventController($container2);
};

$container['ProfileController'] = function ($container2) use ($container) {
	return new Montanari\Controllers\ProfileController($container2);
};

$container['CronController'] = function ($container2) use ($container) {
	return new Montanari\Controllers\CronController($container2);
};

$container['SettingController'] = function ($container2) use ($container) {
	return new Montanari\Controllers\SettingController($container2);
};

$container['DriverController'] = function ($container2) use ($container) {
	return new Montanari\Controllers\DriverController($container2);
};

$container['PassengerController'] = function ($container2) use ($container) {
	return new Montanari\Controllers\PassengerController($container2);
};

$container['AjaxController'] = function ($container2) use ($container) {
	return new Montanari\Controllers\AjaxController($container2);
};

$container['MessageController'] = function ($container2) use ($container) {
	return new Montanari\Controllers\MessageController($container2);
};

$container['NotificationController'] = function ($container2) use ($container) {
	return new Montanari\Controllers\NotificationController($container2);
};
?>

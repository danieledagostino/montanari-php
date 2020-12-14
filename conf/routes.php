<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Montanari\Controllers\LoginController as LoginController;

use Montanari\Auth\AuthCheck as AuthCheck;

$app->group('/ajax', function() use ($app){
	$app->get('/messages', 'AjaxController:messages')->add(AuthCheck::class)->setName('passenger.save');
	$app->get('/notifications', 'AjaxController:notifications')->add(AuthCheck::class);
	$app->get('/pushUpdate/{idPlayer}', 'AjaxController:notificationPushUserUpdate')->add(AuthCheck::class);
});

$app->get('/', 'EventController:events')->setName('home.page');

$app->group('/event', function() use ($app){
	$app->get('/partecipa/{eveId}', 'EventController:subscribe')->add(AuthCheck::class);
	$app->get('/count', 'EventController:count')->add(AuthCheck::class);
	
	$app->get('/avalaible', 'EventController:avalaible')->add(AuthCheck::class);
	$app->get('/joined', 'EventController:joined')->add(AuthCheck::class);
});


$app->group('/user', function() use ($app){
    $app->post('/access', 'LoginController:login');
	$app->post('/save', 'LoginController:newUserSubscription');
	$app->get('/new', 'LoginController:newUserPage');
    $app->get('/logout', 'LoginController:logout')->add(AuthCheck::class);
	$app->get('/login', 'LoginController:index');
	$app->get('/emailConfirm/{code}', 'LoginController:emailConfirm');
});

$app->group('/profile', function() use ($app){
	$app->get('/completion', 'ProfileController:setLivingAddress')->add(AuthCheck::class);
	$app->post('/save', 'ProfileController:saveLivingAddress')->add(AuthCheck::class);
});

$app->group('/cron', function() use ($app){
	$app->get('/deleteNotConfirmedAssociation', 'CronController:deleteNotConfirmedAssociation');
	$app->get('/sendUsersReminderMonthEvents', 'CronController:sendUsersReminderMonthEvents');
	$app->get('/sendUsersReminderAvailableParticipants', 'CronController:sendUsersReminderAvailableParticipants');
	$app->get('/sendUsersReminderInactive', 'CronController:sendUsersReminderInactive');
	$app->get('/sendUsersReminderCarOrganization', 'CronController:sendUsersReminderCarOrganization');
});

$app->group('/setting', function() use ($app){
	$app->get('/', 'SettingController:index')->add(AuthCheck::class);
	$app->post('/save', 'SettingController:save')->add(AuthCheck::class);
	$app->get('/password', 'SettingController:password')->add(AuthCheck::class);
	$app->post('/password/save', 'SettingController:savePassword')->add(AuthCheck::class);
	$app->get('/password/recovery', 'SettingController:recoveryPassword');
	$app->post('/password/recovery', 'SettingController:recoveryPassword');
});

$app->group('/driver', function() use ($app){
	$app->post('/save', 'DriverController:save')->add(AuthCheck::class)->setName('driver.save');
	$app->post('/saveAndContinue', 'DriverController:saveAndContinue')->add(AuthCheck::class);
	$app->get('/events', 'DriverController:associatedEvents')->add(AuthCheck::class);
	$app->get('/detail/{id}', 'DriverController:detail')->add(AuthCheck::class)->setName('driver.detail');
	$app->post('/car/save', 'DriverController:carSave')->add(AuthCheck::class);
	$app->get('/count', 'DriverController:count')->add(AuthCheck::class);
});

$app->group('/passenger', function() use ($app){
	$app->post('/save', 'PassengerController:save')->add(AuthCheck::class)->setName('passenger.save');
	$app->post('/saveAndContinue', 'PassengerController:saveAndContinue')->add(AuthCheck::class);
	$app->get('/events', 'PassengerController:associatedEvents')->add(AuthCheck::class);
	$app->get('/detail/{id}', 'PassengerController:detail')->add(AuthCheck::class)->setName('passenger.detail');
	$app->post('/car/save', 'PassengerController:carSave')->add(AuthCheck::class);
	$app->post('car/detailmap', 'PassengerController:detailMap')->add(AuthCheck::class);
	$app->get('/count', 'PassengerController:count')->add(AuthCheck::class);
});

$app->group('/message', function() use ($app){
	$app->get('/inbox', 'MessageController:inbox')->add(AuthCheck::class);
	$app->get('/sent', 'MessageController:sent')->add(AuthCheck::class);
	$app->get('/compose', 'MessageController:compose')->add(AuthCheck::class);
	$app->get('/compose/{id}', 'MessageController:compose')->add(AuthCheck::class);
	$app->get('/recycle', 'MessageController:recycle')->add(AuthCheck::class);
	
	$app->get('/count', 'MessageController:count')->add(AuthCheck::class);
	$app->get('/detail/{id}', 'MessageController:detail')->add(AuthCheck::class);
	
	$app->post('/send', 'MessageController:send')->add(AuthCheck::class);
	$app->get('/delete/{id}', 'MessageController:delete')->add(AuthCheck::class);
	$app->post('/empty/{id}', 'MessageController:empty')->add(AuthCheck::class);
	$app->post('/empty', 'MessageController:empty')->add(AuthCheck::class);
});

$app->group('/notification', function() use ($app){
	$app->get('/admin', 'NotificationController:admin')->add(AuthCheck::class);
	$app->get('/system', 'NotificationController:system')->add(AuthCheck::class);
	$app->get('/other', 'NotificationController:other')->add(AuthCheck::class);
	$app->get('/all', 'NotificationController:all')->add(AuthCheck::class);
	
	$app->get('/count', 'NotificationController:count')->add(AuthCheck::class);
	$app->get('/detail', 'NotificationController:detail')->add(AuthCheck::class);
	
	$app->post('/delete/{id}', 'NotificationController:delete')->add(AuthCheck::class);
	$app->post('/empty/{id}', 'NotificationController:empty')->add(AuthCheck::class);
	$app->post('/empty', 'NotificationController:empty')->add(AuthCheck::class);
});
	
?>
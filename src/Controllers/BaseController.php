<?php

namespace Montanari\Controllers;

use Interop\Container\ContainerInterface;

use \Slim\App as App;
use \Slim\Container as Container;

use \PHPMailer\PHPMailer\PHPMailer as PHPMailer;

use Montanari\Propel\UserSettings as UserSetting;
use Montanari\Propel\Map\UserSettingsTableMap as UserSettingMap;
use Montanari\Propel\UserSettingsQuery as UserSettingsQuery;

use Montanari\Propel\Messages as Message;
use Montanari\Propel\Map\MessagesTableMap as MessageMap;
use Montanari\Propel\MessagesQuery as MessagesQuery;

use Slim\Views\Twig as Twig;
use Propel\Runtime\Propel;
use Montanari\Propel\Users;

class BaseController
{

    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $container;
	
    protected $db;
    /** @var \Conduit\Services\Auth\Auth */
    protected $auth;
	protected $view;
    protected $logger;
    
    protected $app;
    protected $router;
    
    const EVENT_NOTIFICATION = "EVENT_NOTIFICATION";
    const SYSTEM_NOTIFICATION = "SYSTEM_NOTIFICATION";
    const PRIVATE_MESSAGE = "PRIVATE_MESSAGE";
    
    //messaggi
    const PUSH_DA_AUTISTA = "Un autista ti ha associato.\nControlla la tua e-mail";
    const PUSH_DA_PASSEGGERO = "Un passeggero ti ha associato.\nControlla la tua e-mail";
    
    const MESSAGGIO_PRIVATO = "Messaggio privato da ";
    
    /**
     * BaseController constructor.
     *
     * @param \Interop\Container\ContainerInterface $container
     */
    public function __construct(Container $container)
    {
    	$this->router = $container->get('router');
        $this->container = $container;
		//$this->auth = $container->get('auth');
        $this->logger = $container->get('logger');
        //$this->db = $container->get('db');
		$this->view = $container->get('view');
		
		/*
    	if (isset($_SESSION['loggedUser'])){
    		$loggedUser = $_SESSION['loggedUser'];
    		
    		$userSettings = UserSettingsQuery::create()
    			->findByIdUser($loggedUser->getId());
    		
    		$this->view->
    	}*/
    }
    
    protected function setLoggedUser(Users $loggedUser){
    	$_SESSION['loggedUser'] = $loggedUser;
    }

    protected function getLoggedUser() {
    	return $_SESSION['loggedUser'];
    }
    
    protected function getIdUser(){
    	return $_SESSION['loggedUser']->getId();
    }
    
    protected function randomString($len) {
    
    	$salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ012345678';
    	$length = strlen($salt);
    	$makepass = '';
    	mt_srand(10000000 * (double)microtime());
    	for ($i = 0; $i < $len; $i++) {
    		$makepass .= $salt[mt_rand(0, $length - 1)];
    	}
    	return $makepass;
    }
    
    protected function sendMail(Users $user, $text, $subject = 'Notifica di sistema'){
        $settings = $user->getUserSettings();
        if ($settings->getEmailMessage()){
        	$mail = new PHPMailer;
        	$mail->setFrom('info@montanari.netsons.org', 'Montanari Admin');
       	    $mail->addAddress($user->getEmail(), $user->fullName());
       	    $mail->Subject  = $subject;
        	$mail->isHTML(true);
        	$mail->Body     = $text;
        	if(!$mail->send()) {
        		$this->logger->addError('Email non inviate');
        	} else {
        		$this->logger->addInfo('Email inviate a: '.$email);
        	}
        }else{
            $this->logger->addWarning('L\'utente '.$user->getId().' ha disabilitato l\'invio della mail');
        }
    }
    
    protected function sendNotification($fields){
    
    	$fields["app_id"] =  "5995aa63-ca73-4f1f-b032-6f6ff1996176";
    	//$fields["large_icon"] = "icon.png";
    	$fields = json_encode($fields);
    	$this->logger->info("\nJSON sent:\n".$fields);
    
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic NjliZWZkMGMtNGVhMy00NDI5LWJkMTUtM2MxODI4NTUzM2Iz'));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    	curl_setopt($ch, CURLOPT_HEADER, FALSE);
    	curl_setopt($ch, CURLOPT_POST, TRUE);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    	$response = curl_exec($ch);
    	curl_close($ch);
    
    	$return["allresponses"] = $response;
    	return $return;
    }
    
    protected function sendNotificationToPlayers(Users $user, $message, $url = null, $data = null){
        $settings = $user->getUserSettings();
        if ($settings->getPushMessage() && $user->getIdPlayerNotifiche()){
        	$content = array(
        			"en" => $message,
        			"it" => $message
        	);
        
        	$fields = array(
        	       'include_player_ids' => $user->getIdPlayerNotifiche(),
        			'contents' => $content
        	);
        
        	if (isset($url)){
        		$fields["url"] = $url;
        	}
        
        	if (isset($data)){
        		$fields["data"] = $data;
        	}
        
        	return $this->sendNotification($fields);
        }else{
            $this->logger->addWarning('L\'utente '.$user->getId().' ha disabilitato l\'invio della notifiche push');
        }
    }
    
    protected function sendNotificationToAll($msg){
    	$content = array(
    			"en" => $msg,
    			"it" => $msg
    	);
    
    	$fields = array(
    			'included_segments' => array('All'),
    			'contents' => $content
    	);
    
    	return $this->sendNotification($fields);
    }
    
    protected function saveMessage(Users $userTo, string $subject, string $message){
        $con = Propel::getWriteConnection(MessageMap::DATABASE_NAME);
        
        $message = new Message();
        $message->setIdUserFrom(null);
        $message->setIdUserTo($userTo->getId());
        $message->setSubject($subject);
        $message->setMessage($message);
        $message->setType(SYSTEM_NOTIFICATION);
        
        try{
            $message->save($con);
        }catch (\Propel\Runtime\Exception\PropelException $e){
            $this->logger->addError('Messaggio non salvato '.$e->getMessage());
        }
    }
}

<?php
namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Facebook\Facebook;

use Montanari\Controllers\BaseController as BaseController;

use Propel\Runtime\Propel as Propel;

use Montanari\Propel\Messages as Message;
use Montanari\Propel\Map\MessagesTableMap as MessageMap;
use Montanari\Propel\MessagesQuery as MessagesQuery;

use Montanari\Propel\AdminMessages as AdminMessage;
use Montanari\Propel\Map\AdminMessagesTableMap as AdminMessageMap;
use Montanari\Propel\AdminMessagesQuery as AdminMessagesQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Exception\PropelException;

class AjaxController extends BaseController{

	public function notifications(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Cerco notifiche non lette');
        
        $loggedUser = $this->getLoggedUser();
        
        $notificationsNotRead = MessagesQuery::create()
	        ->filterByIdUserTo($loggedUser->getId())
	        ->filterByType(BaseController::PRIVATE_MESSAGE, Criteria::NOT_EQUAL)
	        ->filterByDelete(0)
	        ->filterByRead(0)
	        ->count();
        
        $this->logger->addInfo('Trovate '.$notificationsNotRead.' notifiche non lette');
        return $response->withJson($notificationsNotRead);
    }
    
	public function messages(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Cerco messaggi non letti');
        
		$loggedUser = $this->getLoggedUser();
		
        $messagesNotRead = MessagesQuery::create()
	        ->filterByIdUserTo($loggedUser->getId())
	        ->filterByType(BaseController::PRIVATE_MESSAGE)
	        ->filterByIdUserFrom(null, Criteria::NOT_EQUAL)
	        ->filterByDelete(0)
	        ->filterByRead(0)
	        ->count();
        
        $this->logger->addInfo('Trovati '.$messagesNotRead.' messaggi non letti');
		return $response->withJson($messagesNotRead);
    }
    
    public function notificationPushUserUpdate(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Aggiorno l\'id player per le notifiche push');
    	
    	$loggedUser = $this->getLoggedUser();
    	
    	$idPlayer = $args["idPlayer"];
    	
    	$loggedUser->setIdPlayerNotifiche($idPlayer);
    	
    	try{
    		$loggedUser->save($con);
    		$this->setLoggedUser($loggedUser);
    		
    		$this->logger->addInfo('Id player per le notifiche push aggiornato');
    	} catch (PropelException $e) {
    		//$con->rollback();
    		$this->logger->addError('Si è verificato un errore durante l\'aggiornamento dell\'id player per le notifiche');
    	}
    }
}
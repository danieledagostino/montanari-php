<?php

namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

use Propel\Runtime\Propel as Propel;

use Montanari\Controllers\BaseController as BaseController;

use Montanari\Propel\Messages as Message;
use Montanari\Propel\Map\MessagesTableMap as MessageMap;
use Montanari\Propel\MessagesQuery as MessagesQuery;

use Propel\Runtime\ActiveQuery\Criteria;
use Montanari\Propel\EventsQuery;
use Montanari\Propel\UsersQuery;
use Propel\Runtime\Exception\PropelException;

class MessageController extends BaseController{

	public function inbox(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Cerco messaggi');
        
		$loggedUser = $this->getLoggedUser();
		
        $messages = MessagesQuery::create()
        //->select(array('id', 'id_user_from', 'subject', 'read', 'delete', 'insert_date'))
	        ->filterByIdUserTo($loggedUser->getId())
	        ->filterByType(BaseController::PRIVATE_MESSAGE)
	        ->filterByIdUserFrom(null, Criteria::NOT_EQUAL)
	        ->filterByDelete(0)
	        ->find();
        
        $this->logger->addInfo('Trovati '.$messages->count().' messaggi ricevuti');
        return $this->view->render($response, 'messages/inbox.html', ['messages' => $messages]);
    }
    
    public function sent(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Cerco messaggi');
        
        $loggedUser = $this->getLoggedUser();
    	
    	$messages = MessagesQuery::create()
    	    ->filterByIdUserTo(null, Criteria::NOT_EQUAL)
    	    ->filterByType(BaseController::PRIVATE_MESSAGE)
        	->filterByIdUserFrom($loggedUser->getId())
        	->filterByDelete(0)
        	->find();
    	
        $this->logger->addInfo('Trovati '.$messages->count().' messaggi inviati');
    	
    	return $this->view->render($response, 'messages/outbox.html', ['messages' => $messages]);
    }
    
    public function count(Request $request, Response $response, array $args)
    {
        $loggedUser = $this->getLoggedUser();
        
        $countMessage['inbox'] = MessagesQuery::create()
            ->filterByIdUserTo($loggedUser->getId())
            ->filterByType(BaseController::PRIVATE_MESSAGE)
            ->filterByIdUserFrom(null, Criteria::NOT_EQUAL)
            ->filterByDelete(0)
            ->count();
        
        $countMessage['sent'] = MessagesQuery::create()
            ->filterByIdUserTo(null, Criteria::NOT_EQUAL)
            ->filterByType(BaseController::PRIVATE_MESSAGE)
            ->filterByIdUserFrom($loggedUser->getId())
            ->filterByDelete(0)
            ->count();
        
        $countMessage['deleted'] = MessagesQuery::create()
            ->filterByIdUserTo($loggedUser->getId())
            ->_or()
            ->filterByIdUserFrom($loggedUser->getId())
            ->filterByType(BaseController::PRIVATE_MESSAGE)
            ->filterByDelete(1)
            ->count();
            
        return $response->withJson($countMessage);
    }
    
    public function detail(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Carico il messaggio con id '+$args['id']);
        
        $con = Propel::getWriteConnection(MessageMap::DATABASE_NAME);
        
        $loggedUser = $this->getLoggedUser();
        
        $message = MessagesQuery::create()
            ->findOneById($args['id']);
    
        $this->logger->addInfo($message);
        
        $outputVars['id'] = $message->getId();
        $outputVars['from'] = htmlspecialchars($message->getUserFrom()->getNome()." ".$message->getUserFrom()->getCognome());
        $outputVars['subject'] = htmlspecialchars($message->getSubject());
        $outputVars['body'] = htmlspecialchars($message->getMessage());
        
        $message->setRead(1);
        $message->save($con);
        //bisogna ricreare gli oggetti aggiungendo nello schema a livello table o database la proprietà identifierQuoting che permette l'utilizzo di chiavi speciali come nomi colonne o tabella
        
        return $this->view->render($response, 'messages/detail.html', $outputVars);
    }
    
    public function compose(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Apro la pagina per comporre un messaggio');
    	
    	$loggedUser = $this->getLoggedUser();
    	
    	$users = UsersQuery::create()->filterById($loggedUser->getId(), Criteria::NOT_EQUAL);
    	$outputVars['users'] = $users;
    	
    	$driverEvents = EventsQuery::create('')
        	->useDriversQuery()
        	   ->filterByIdUser($loggedUser->getId(), Criteria::EQUAL)
        	->endUse()
        	->find();
    	$outputVars['driverEvents'] = $driverEvents;
    	
    	$passengerEvents = EventsQuery::create()
        	->usePassengersQuery()
        	   ->filterByIdUser($loggedUser->getId(), Criteria::EQUAL)
        	->endUse()
        	->find();
    	$outputVars['passengerEvents'] = $passengerEvents;

    	if (isset($args['id'])){
    	    $modalDetailFormReplyID = $args['id'];
    	    
    	    $replyMsg = MessagesQuery::create()->findOneById($modalDetailFormReplyID);
    	    
    	    $outputVars['replyMsg'] = $replyMsg;
    	    
    	    $outputVars['reSubject'] = 'RE: '.$replyMsg->getSubject();
    	}
    	
    	return $this->view->render($response, 'messages/compose.html', $outputVars);
    }
    
    public function send(Request $request, Response $response, array $args)
    {
        
        $this->logger->addInfo('Carico i dati del messaggio');
        
        $data = $request->getParsedBody();
        
        $loggedUser = $this->getLoggedUser();
        
        $message = new Message();
        $message->setIdUserFrom($loggedUser->getId());
        $toUser = UsersQuery::create()->findOneById($data['toUser']);
        
        $message->setIdUserTo($data['toUser']);
        $message->setSubject($data['subject']);
        $message->setMessage($data['message']);
        $message->setType(BaseController::PRIVATE_MESSAGE);
        if (isset($data['replyMsgId'])){
            $message->setParent($data['replyMsgId']);
        }
        
        try{
            $saved = $message->save();
            
            if ($saved){
                $this->sendMail($toUser, "L'utente ".$loggedUser->fullName()." ti ha inviato un messaggio privato", BaseController::MESSAGGIO_PRIVATO.$loggedUser->getNome());
                
                $this->sendNotificationToPlayers($toUser, BaseController::MESSAGGIO_PRIVATO, $loggedUser->getNome());
            
                $outputVars['message'] = 'Messaggio inviato correttamente';
            }
        } catch (PropelException $e) {
            $this->logger->addError('Si è verificato un errore durante il salvataggio di questo messaggio');
            //$this->logger->error((string) $e);
            return $this->view->render($response, 'common/error.html');
        }
        
        return $this->view->render($response, 'messages/compose.html', $outputVars);
    }
    
    public function delete(Request $request, Response $response, array $args)
    {
        
        $this->logger->addInfo('Cancello il messaggio con id '+$args['id']);
        
        $loggedUser = $this->getLoggedUser();
        
        $message = MessagesQuery::create()->findOneById($args['id']);
        $message->setDelete(1);
        
        try{
            $deleted = $message->save();
            
        } catch (PropelException $e) {
            $this->logger->addError('Si è verificato un errore durante la cancellazione di questo messaggio');
            //$this->logger->error((string) $e);
            return $this->view->render($response, 'common/error.html');
        }
        
        return $response->withJson(['deleted' => $deleted]);
    }
    
    public function recycle(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Cerco messaggi');
        
        $loggedUser = $this->getLoggedUser();
        
        $arrived = MessagesQuery::create()
            ->filterByIdUserTo($loggedUser->getId())
            ->filterByType(BaseController::PRIVATE_MESSAGE)
            ->filterByIdUserFrom(null, Criteria::NOT_EQUAL)
            ->filterByDelete(1)
            ->find();
        $outputVars['arrived'] = $arrived;
        
        $sent = MessagesQuery::create()
            ->filterByIdUserTo(null, Criteria::NOT_EQUAL)
            ->filterByType(BaseController::PRIVATE_MESSAGE)
            ->filterByIdUserFrom($loggedUser->getId())
            ->filterByDelete(1)
            ->find();
        $outputVars['sent'] = $sent;
            
        $this->logger->addInfo('Trovati '.$arrived->count().' messaggi ricevuti cancellati e '.$sent->count().' messaggi inviati cancellati');
        return $this->view->render($response, 'messages/recycle.html', $outputVars);
    }
}
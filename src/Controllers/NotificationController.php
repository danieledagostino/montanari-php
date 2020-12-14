<?php

namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

use Propel\Runtime\Propel as Propel;

use Montanari\Controllers\BaseController as BaseController;

use Montanari\Propel\Messages as Message;
use Montanari\Propel\Map\MessagesTableMap as MessageMap;
use Montanari\Propel\MessagesQuery as MessagesQuery;

use Montanari\Propel\AdminMessages as AdminMessage;
use Montanari\Propel\Map\AdminMessagesTableMap as AdminMessagesMap;
use Montanari\Propel\AdminMessagesQuery as AdminMessagesQuery;

use Propel\Runtime\ActiveQuery\Criteria;
use Montanari\Propel\EventsQuery;
use Montanari\Propel\UsersQuery;
use Propel\Runtime\Exception\PropelException;

class NotificationController extends BaseController{

	public function admin(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Salvo i dati dell\'iscirzione come autista');
        
        $loggedUser = $this->getLoggedUser();
        
        $messages = AdminMessagesQuery::create()
            ->filterByDelete(0)
            ->find();
        
        $this->logger->addInfo('Trovati '.$messages->count().' messaggi di sistema');
        
        return $this->view->render($response, 'notify/admin.html', ['messages' => $messages]);
    }
    
    public function count(Request $request, Response $response, array $args)
    {
        $countMessage['adminMessages'] = AdminMessagesQuery::create()
            ->filterByDelete(0)->count();
        
        $countMessage['systemMessages'] = MessagesQuery::create()
            ->filterByIdUserTo($loggedUser->getId())
            ->filterByType(BaseController::SYSTEM_NOTIFICATION)
            ->filterByIdUserFrom(null, Criteria::NOT_EQUAL)
            ->filterByDelete(0)
            ->count();
        
        $countMessage['eventMessages'] = MessagesQuery::create()
            ->filterByIdUserTo($loggedUser->getId())
            ->filterByType(BaseController::EVENT_NOTIFICATION)
            ->filterByIdUserFrom(null, Criteria::NOT_EQUAL)
            ->filterByDelete(0)
            ->count();
        
        return $response->withJson($countMessage);
    }
    
    public function system(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Salvo i dati dell\'iscirzione come autista');
        
        $loggedUser = $this->getLoggedUser();
        
        $messages = MessagesQuery::create()
            ->select(array('id', 'subject', 'read', 'delete', 'insert_date'))
            ->filterByIdUserTo($loggedUser->getId())
            ->filterByType(BaseController::SYSTEM_NOTIFICATION)
            ->filterByIdUserFrom(null, Criteria::NOT_EQUAL)
            ->filterByDelete(0)
            ->find();
        
        $this->logger->addInfo('Trovati '.$messages->count().' messaggi ricevuti');
        
        return $this->view->render($response, 'notify/system.html', ['messages' => $messages]);
    }
    
    public function other(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Salvo i dati dell\'iscirzione come autista');
        
        $loggedUser = $this->getLoggedUser();
        
        $messages = MessagesQuery::create()
            ->select(array('id', 'subject', 'read', 'delete', 'insert_date'))
            ->filterByIdUserTo($loggedUser->getId())
            ->filterByType(BaseController::EVENT_NOTIFICATION)
            ->filterByIdUserFrom(null, Criteria::NOT_EQUAL)
            ->filterByDelete(0)
            ->find();
        
        $this->logger->addInfo('Trovati '.$messages->count().' messaggi ricevuti');
        
        return $this->view->render($response, 'notify/other.html', ['messages' => $messages]);
    }
    
    public function recycle(Request $request, Response $response, array $args)
    {
    
    }
    
    public function all(Request $request, Response $response, array $args)
    {
        
    }
}
<?php

namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

use Propel\Runtime\Propel as Propel;

use Montanari\Controllers\BaseController as BaseController;

use Montanari\Propel\Users as User;
use Montanari\Propel\Map\UsersTableMap as UserMap;
use Montanari\Propel\UsersQuery as UsersQuery;
use Propel\Runtime\Exception\PropelException;

class ProfileController extends BaseController{

	public function setLivingAddress(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Carico la pagina per impostare il domicilio su mappa');
        
        $user = $this->getLoggedUser();
        return $this->view->render($response, 'profiles/completion.html', ['user' => $user]);
    }
    
    public function saveLivingAddress(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Salvo il domicilio');
    	
    	$user = $this->getLoggedUser();
    	
    	$data = $request->getParsedBody();
    	
    	$con = Propel::getWriteConnection(UserMap::DATABASE_NAME);
    	
    	try{
    		UsersQuery::create()->findPk($user->getId(), $con)->
    			setAutonomia($data['autonomia'])->
    			setAbitazione($data['abitazione'])->
    			save();
    		
    		$outputVars['message'] = 'Profilo salvato!';
    		
    		$user->reload();
    		
    		$_SESSION['loggedUser'] = $user;
    		
    		$outputVars['user'] = $user;
    		$this->logger->addInfo('Domicilio salvato');
    	} catch (PropelException $e) {
       		//$con->rollback();
       		$this->logger->addError('Si è verificato un errore durante il salvataggio del profilo');
       		return $this->view->render($response, 'common/error.html');
       	}
       		
    	
    	return $this->view->render($response, 'profiles/completion.html', $outputVars);
    }
	
}
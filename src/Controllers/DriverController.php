<?php

namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

use Propel\Runtime\Propel as Propel;

use Montanari\Controllers\BaseController as BaseController;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Exception\PropelException as PropelException;

use Montanari\Propel\Events as Event;
use Montanari\Propel\Map\EventsTableMap as EventMap;
use Montanari\Propel\EventsQuery as EventsQuery;

use Montanari\Propel\Drivers as Driver;
use Montanari\Propel\Map\DriversTableMap as DriverMap;
use Montanari\Propel\DriversQuery as DriversQuery;

use Montanari\Propel\Passengers as Passenger;
use Montanari\Propel\Map\PassengersTableMap as PassengerMap;
use Montanari\Propel\PassengersQuery as PassengersQuery;

use Montanari\Propel\CarOrganization as CarOrganization;
use Montanari\Propel\Map\CarOrganizationTableMap as CarOrganizationMap;
use Montanari\Propel\CarOrganizationQuery as CarOrganizationQuery;

use Montanari\Propel\UsersQuery;

class DriverController extends BaseController{

	public function save(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Salvo i dati dell\'iscirzione come autista');
        
        $data = $request->getParsedBody();
        $driver = $this->saveDriver($data);
        
        $event = EventsQuery::create()->findOneById($data['idEvent']);
        
        return $this->view->render($response, 'user/personalarea.html', 
        		['message' => 'Ti sei appena registrato come autista all\'evento '.$event->getName()]);
    }
    
    public function count(Request $request, Response $response, array $args)
    {
        $loggedUser = $this->getLoggedUser();
        
        $count = EventsQuery::create('')
            ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
            ->useDriversQuery()
            ->filterByIdUser($loggedUser->getId(), Criteria::EQUAL)
            ->endUse()
            ->count();
        
            return $response->withJson(['driver' => $count]);
    }
    
    public function saveAndContinue(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Salvo i dati dell\'iscirzione come autista');
    	
    	$data = $request->getParsedBody();
    	
    	$driver = $this->saveDriver($data);
    	
    	$event = EventsQuery::create()->findOneById($data['idEvent']);
    	
    	$availablePassengers = PassengersQuery::create()
    			->useEventsQuery()
    				->filterById($event->getId())
    				->useCarOrganizationQuery()
    					->filterByIdPassenger(null, Criteria::EQUAL)
    				->endUse()
    			->endUse()
    		->find();
    	
    	$confirmedPassenger = PassengersQuery::create()
    			->useEventsQuery()
    				->filterById($event->getId())
    				->useCarOrganizationQuery()
    					//->filterByIdDriver($driver)
    					->filterByIdPassenger(null, Criteria::NOT_EQUAL)
    				->endUse()
    			->endUse()
    		->find();
    				
    	
    	$this->logger->addInfo('Carico i dati dei passeggeri disponibili per questo evento');
    	
    	return $response->withRedirect($this->router->pathFor('driver.detail', ['id' => $data['idEvent']]));
    }
    
    public function associatedEvents(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Carico gli eventi associati a questo utente come autista');
    	
    	$user = $this->getLoggedUser();
    	
    	$events = EventsQuery::create()
	    		->useDriversQuery()
	    			->filterByUsers($user)
	    		->endUse()
    		->find();
    	
    	return $this->view->render($response, 'drivers/events.html', ['events' => $events]);
    }
    
    public function detail(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Carico l\'evento '.$args['id'].' nel dettaglio');
    	 
    	$user = $this->getLoggedUser();
    	
    	$event = \Montanari\Propel\Base\EventsQuery::create()->findOneById($args['id']);
    	
    	$availablePassengers = PassengersQuery::create()
    			->filterByIdEvent($event->getId())
    			->useCarOrganizationQuery('car', 'left join')
    				->filterByIdPassenger(null, Criteria::EQUAL)
    			->endUse()
    		->find();
    	
    	$driver = DriversQuery::create()->filterByIdUser($user->getId())->filterByIdEvent($event->getId())->findOne();
    	
    	$confirmedPassenger = CarOrganizationQuery::create()
    			->filterByEvents($event)
    			->filterByIdDriver($driver->getId())
    		->find();
    	
    	return $this->view->render($response, 'drivers/detail.html', 
    			['availablePassengers' => $availablePassengers,
    			 'confirmedPassenger' => $confirmedPassenger,
    			 'event' => $event,
    			 'driver' => $driver
    			]);
    }
    
    public function carSave(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Salvo l\'associazione richiesta ');
    
    	$con = Propel::getWriteConnection(CarOrganizationMap::DATABASE_NAME);
    	$data = $request->getParsedBody();
    	
    	$associationProbablyToRemove = CarOrganizationQuery::create()
    	   ->filterByIdDriver($data['idDriver'])
    	   ->filterByIdEvent($data['idEvent'])
    	   ->filterByIdPassenger($data['idPassenger'], Criteria::NOT_IN)
    	   ->find();
    	
        try{
            foreach ($associationProbablyToRemove as $org){
                if (!$org->getConfirmed()){
                    $org->delete($con);
                }
            }
        } catch (PropelException $e) {
           $this->logger->addError('Si è verificato un errore durante la rimozione dell\'associazione precdentemente effettuata');
           return $this->view->render($response, 'common/error.html');
        }
    	
    	$user = $this->getLoggedUser();
    	
    	$con = Propel::getWriteConnection(DriverMap::DATABASE_NAME);
    	
    	$car = new CarOrganization();
    	$car->setIdDriver($data['idDriver']);
    	$car->setIdEvent($data['idEvent']);
    	
    	$selectedPassengers = $data['idPassenger'];
    	$savedCars = [];
    	
    	try{
    		$con->beginTransaction();
    		foreach ($selectedPassengers as $sel){
    			$car->setIdPassenger($sel);
    			$car->setConfirmCode($this->randomString(16));
    			
    			$car->save($con);
    			array_push($savedCars, $car);
    		}
    		
    		$saved = $con->commit();
    		if ($saved){
    		    foreach ($savedCars as $sel){
    		        $passenger = $sel->getPassenger();
    		        $passengerUser = $passenger->getUsers();
    		        
		            $this->sendMail($passengerUser, '');
    		        
		            $this->sendNotificationToPlayers($passengerUser, PUSH_DA_AUTISTA);
		            
		            $this->saveMessage($passengerUser, 'Richiesta da '.$user->getNome(), '');
    		    }
    		}
    	} catch (PropelException $e) {
    		$con->rollback();
    		$this->logger->addError('Si è verificato un errore durante il salvataggio di questo autista');
    		return $this->view->render($response, 'common/error.html');
    	}
    	
    }
    
    private function saveDriver($data){
    	$con = Propel::getWriteConnection(DriverMap::DATABASE_NAME);
    	$driver = new Driver();
    	
    	$loggedUser = $this->getLoggedUser();
    	
    	$driver->setIdEvent($data['idEvent']);
    	$driver->setIdUser($this->getIdUser());
    	$driver->setSeatsNumber($data['posti']);
    	$driver->setRoad($data['strada']);
    	
    	try {
    		$driver->save($con);
    		
    		$driver->reload();
    		$this->logger->addInfo('Dati dell\'autista salvati per la sottoscrizione all\'evento');
    	} catch (PropelException $e) {
    		//$con->rollback();
    		$this->logger->addError('Si è verificato un errore durante il salvataggio di questo autista');
    		return $this->view->render($response, 'common/error.html');
    	}
    	
    	return $driver;
    }
}
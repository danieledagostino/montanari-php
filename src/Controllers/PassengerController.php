<?php

namespace Montanari\Controllers;

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

use Propel\Runtime\Propel as Propel;

use Montanari\Controllers\BaseController as BaseController;

use Montanari\Propel\Events as Event;
use Montanari\Propel\Map\EventsTableMap as EventMap;
use Montanari\Propel\EventsQuery as EventsQuery;

use Montanari\Propel\Users as User;
use Montanari\Propel\Map\UsersTableMap as UserMap;
use Montanari\Propel\UsersQuery as UsersQuery;

use Montanari\Propel\Passengers as Passenger;
use Montanari\Propel\Map\PassengersTableMap as PassengerMap;
use Montanari\Propel\PassengersQuery as PassengersQuery;

use Montanari\Propel\Map\DriversTableMap as DriverMap;
use Montanari\Propel\DriversQuery as DriversQuery;

use Montanari\Propel\CarOrganization as CarOrganization;
use Montanari\Propel\Map\CarOrganizationTableMap as CarOrganizationMap;
use Montanari\Propel\CarOrganizationQuery as CarOrganizationQuery;
use Propel\Runtime\ActiveQuery\Criteria;

use Propel\Runtime\Formatter\ObjectFormatter as ObjectFormatter;
use Propel\Runtime\Exception\PropelException;

class PassengerController extends BaseController{

public function save(Request $request, Response $response, array $args)
    {
        try{
            $this->logger->addInfo('Salvo i dati dell\'iscirzione come autista');
            
            $data = $request->getParsedBody();
            $passenger = $this->savePassenger($data);
            
            $event = EventsQuery::create()->findOneById($data['idEvent']);
            
            return $this->view->render($response, 'user/personalarea.html', 
            		['message' => 'Ti sei appena registrato come passeggero all\'evento '.$event->getName()]);
        } catch (PropelException $e) {
            //$con->rollback();
            $this->logger->addError('Si è verificato un errore durante il salvataggio di questo passeggero');
            return $this->view->render($response, 'common/error.html');
        }
    }
    
    public function count(Request $request, Response $response, array $args)
    {
        $loggedUser = $this->getLoggedUser();
        
        $count = EventsQuery::create()
            ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
            ->usePassengersQuery()
            ->filterByIdUser($loggedUser->getId(), Criteria::EQUAL)
            ->endUse()
            ->count();
            
        return $response->withJson(['passenger' => $count]);
    }
    
    public function saveAndContinue(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Salvo i dati dell\'iscirzione come passeggero');
    	try {
        	$data = $request->getParsedBody();
        	
        	$passenger = $this->savePassenger($data);
        	
        	$event = EventsQuery::create()->findOneById($data['idEvent']);
        	
        	$this->logger->addInfo('Carico i dati degli autisti disponibili per questo evento');
        	
        	return $response->withRedirect($this->router->pathFor('passenger.detail', ['id' => $data['idEvent']]));
    	} catch (PropelException $e) {
    	    //$con->rollback();
    	    $this->logger->addError('Si è verificato un errore durante il salvataggio di questo passeggero');
    	    return $this->view->render($response, 'common/error.html');
    	}
    }
    
    private function savePassenger($data){
    	$con = Propel::getWriteConnection(PassengerMap::DATABASE_NAME);
    	$passenger = new Passenger();
    	
    	$loggedUser = $this->getLoggedUser();
    	
    	$passenger->setIdEvent($data['idEvent']);
    	$passenger->setIdUser($this->getIdUser());
    	//$passenger->setMeetingPoint($v);
    	
		$passenger->save($con);
		$passenger->reload();
		
		$this->logger->addInfo('Dati del passeggero salvati per la sottoscrizione all\'evento');
    	
    	return $passenger;
    }
    
    public function associatedEvents(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Carico gli eventi associati a questo utente come passeggero');
    	 
    	$user = $this->getLoggedUser();
    	 
    	$events = EventsQuery::create()
    	->usePassengersQuery()
    		->filterByUsers($user)
    	->endUse()
    	->find();
    	 
    	return $this->view->render($response, 'passengers/events.html', ['events' => $events]);
    }
    
    public function detail(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Carico l\'evento '.$args['id'].' nel dettaglio');
    
    	$user = $this->getLoggedUser();
    	 
    	$event = \Montanari\Propel\Base\EventsQuery::create()->findOneById($args['id']);
    	 
    	$availableDriver = DriversQuery::create()
    	->filterByIdEvent($event->getId())
    		->useCarOrganizationQuery('car', 'left join')
    			->filterByIdDriver(null, Criteria::EQUAL)
    		->endUse()
    	->find();
    	 
    	$passenger = PassengersQuery::create()->filterByIdUser($user->getId())->filterByIdEvent($event->getId())->findOne();
    	
    	$query = "select co.id_driver, d.seats_number seats_available, count(*) seats_taken ";
    	$query .= "from car_organization co ";
    	$query .= "inner join drivers d on d.id = co.id_driver and d.id_event = co.id_event ";
    	$query .= "where co.id_event = ? ";
    	$query .= "group by co.id_driver, co.id_event ";
    	$query .= "having seats_taken < seats_available";
    	
    	$con = Propel::getConnection(CarOrganizationMap::DATABASE_NAME);
    	$stmt = $con->prepare($query);
    	$stmt->bindValue(1, $event->getId());
 		$stmt->execute();
 		
 		//$formatter = new ObjectFormatter();
 		//$formatter->setClass('\Montanari\Propel\CarOrganization'); //full qualified class name
 		//$driverWithSeats = $formatter->format($con->getDataFetcher($stmt));
 		
 		$result = $stmt->fetchAll();
 		$driverWithSeats = [];
 		
 		foreach ($result as $res){
 			$car = new CarOrganization();
 			$car->setIdDriver($res['id_driver']);
 			$car->setSeatsAvailable($res['seats_available']);
 			$car->setSeatsTaken($res['seats_taken']);
 			
 			array_push($driverWithSeats, $car);
 		}
    	
    	return $this->view->render($response, 'passengers/detail.html',
    			['availableDriver' => $availableDriver,
    			 'driverWithSeats' => $driverWithSeats,
    			 'event' => $event,
    			 'passenger' => $passenger
    			]);
    }
    
    public function detailMap(Request $request, Response $response, array $args)
    {
        $driver = DriversQuery::create()->findOneById($args['idDriver']);
        
        return $this->view->render($response, 'passengers/detailMap.html',
            ['driver' => $driver,
             'passenger' => $passenger
            ]);
    }
    
    public function carSave(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Salvo l\'associazione richiesta ');
        
        $data = $request->getParsedBody();
        
        $con = Propel::getWriteConnection(DriverMap::DATABASE_NAME);
        
        $user = $this->getLoggedUser();
        
        $car = new CarOrganization();
        $car->setIdDriver($data['idDriver']);
        $car->setIdEvent($data['idEvent']);
        $passenger = PassengersQuery::create()->findOneById($data['idPassenger']);
        $passenger->setMeetingPoint($data['meetingPoint']);
        
        $car->setPassenger($passenger);
        
        
        try{
                
            $saved = $car->save($con);
            
            if ($saved){
                $car->reload();
    
                $driver = $car->getDriver();
                $driverUser = $driver->getUsers();
                $settings = $driverUser->getUserSettings();
                        
                $this->sendMail($driverUser, '', 'Richiesta da '.$user->getNome());
                
                $this->sendNotificationToPlayers($driverUser, PUSH_DA_PASSEGGERO);
                
                $this->saveMessage($driverUser, 'Richiesta da '.$user->getNome(), '');
            }
        } catch (PropelException $e) {
            $con->rollback();
            $this->logger->addError('Si è verificato un errore durante il salvataggio di questo autista');
            return $this->view->render($response, 'common/error.html');
        }
        
    }
}
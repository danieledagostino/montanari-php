<?php
namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Facebook\Facebook;

use Montanari\Controllers\BaseController as BaseController;

use Propel\Runtime\Propel as Propel;

use Montanari\Propel\Events as Event;
use Montanari\Propel\Map\EventsTableMap as EventMap;
use Montanari\Propel\EventsQuery as EventsQuery;

use Montanari\Propel\Drivers as Driver;
use Montanari\Propel\Map\DriversTableMap as DriverMap;
use Montanari\Propel\DriversQuery as DriversQuery;

use Montanari\Propel\Passengers as Passenger;
use Montanari\Propel\Map\PassengersTableMap as PassengerMap;
use Montanari\Propel\PassengersQuery as PassengersQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Montanari\Propel\Map\EventsTableMap;
use Montanari\Propel\Map\DriversTableMap;
use Montanari\Propel\Map\PassengersTableMap;

class EventController extends BaseController{

	public function subscribe(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Procedura di sottoscrizione all\'evento');
        
        $eveId = $args['eveId'];
        $loggedUser = $this->getLoggedUser();
        $outputVars['user'] = $loggedUser;
        
        //controlla prima se l'evento è già registrato per questo utente
        $eventForDriver = EventsQuery::create()->filterByIdFb($eveId)->useDriversQuery()->filterByIdUser($loggedUser->getId())->endUse()->findOne();
        $eventForPassenger = EventsQuery::create()->filterByIdFb($eveId)->usePassengersQuery()->filterByIdUser($loggedUser->getId())->endUse()->findOne();
        
        if ($eventForDriver != null){
            $outputVars['id'] = $eventForDriver->getId();
            return $response->withRedirect($this->router->pathFor('driver.detail', $outputVars));
        }
        
        if ($eventForPassenger != null){
            $outputVars['id'] = $eventForPassenger->getId();
            return $response->withRedirect($this->router->pathFor('passenger.detail', $outputVars));
        }
        
        
        $event = \Montanari\Propel\Base\EventsQuery::create()->findByIdFb($eveId);
        
        if (!$event->isEmpty()){
        	$this->logger->addInfo('Trovato evento '.$event->getFirst());
        	$outputVars['event'] = $event->getFirst();
        }
        
        
        //if ()
        return $this->view->render($response, 'events/iscrizione.html', 
        		$outputVars);
    }
    
    public function count(Request $request, Response $response, array $args)
    {
        $loggedUser = $this->getLoggedUser();
        
        $idsFb = array();
        
        $joinEvents = EventsQuery::create('')
            ->select('id')
            ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
            ->useDriversQuery()
            ->filterByIdUser($loggedUser->getId(), Criteria::EQUAL)
            ->endUse()
            ->_or()
            ->usePassengersQuery()
            ->filterByIdUser($loggedUser->getId(), Criteria::EQUAL)
            ->endUse()
            ->find();
        
            $countEvents['joinEvents'] = $joinEvents->count();
        
        foreach ($joinEvents as $eve){
            array_push($idsFb, $eve->getId());
        }
        
        $countEvents['otherEvents'] = EventsQuery::create()
            ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
            ->orderBy(EventMap::COL_EVENT_DATE)->
            _and()->filterBy("Id", $idsFb, Criteria::NOT_IN)
            ->count();
        
            return $response->withJson($countEvents);
    }
    
	public function events(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Carico eventi disponibili da Facebook');
        
		$loggedUser = $this->getLoggedUser();
        //carica altri eventi già associati
        
		$page = 'events/eventi.html';
		
		$idsFb = array();
		
		//bisogna mettere in joi le tabelle con events
		if ($loggedUser != null){
			
			$driverEvents = EventsQuery::create('')
			    ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
				->useDriversQuery()
					->filterByIdUser($loggedUser->getId(), Criteria::EQUAL)
				->endUse()
				->find();
			$outputVars['driverEvents'] = $driverEvents;
			
			$passengerEvents = EventsQuery::create()
			    ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
				->usePassengersQuery()
			 		->filterByIdUser($loggedUser->getId(), Criteria::EQUAL)
			 	->endUse()
				->find();
			$outputVars['passengerEvents'] = $passengerEvents;
			
			foreach ($driverEvents as $eve){
				array_push($idsFb, $eve->getId());
			}
			
			foreach ($passengerEvents as $eve){
				array_push($idsFb, $eve->getId());
			}
			
			$page = 'user/personalarea.html';
		}
		
		$otherEvents = \Montanari\Propel\Base\EventsQuery::create()
			->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
			->orderBy(EventMap::COL_EVENT_DATE)->
			_and()->filterBy("Id", $idsFb, Criteria::NOT_IN)
			->find();
		
		$outputVars['otherEvents'] = $otherEvents;
		$outputVars['user'] = $loggedUser;
		
		if (isset($args['message'])){
		    $outputVars['message'] = $args['message'];
		}
			
		return $this->view->render($response, $page, $outputVars);
    }
    
}
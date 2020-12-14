<?php
namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Facebook\Facebook;

use Propel\Runtime\Propel as Propel;

use Montanari\Controllers\BaseController as BaseController;

use Montanari\Propel\Events as Event;
use Montanari\Propel\Map\EventsTableMap as EventMap;
use Montanari\Propel\EventsQuery as EventsQuery;

class CronController extends BaseController{

	public function deleteOldEvents(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Cancella eventi passati');
        
    }
    
    public function sendUsersReminderMonthEvents(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Cancella eventi passati');
    
    }
    
    public function deleteNotConfirmedAssociation(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Cancella eventi passati');
    
    }
    
    public function sendUsersReminderAvailableParticipants(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Cancella eventi passati');
    
    }
    
    public function sendUsersReminderInactive(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Cancella eventi passati');
    
    }
    
    public function sendUsersReminderCarOrganization(Request $request, Response $response, array $args)
    {
    	$this->logger->addInfo('Invio il reminder per l\'organizzazione della macchina');
    	
    	$event = EventsQuery::create('')
        	->where("WEEK(event_date, 1) = WEEK(NOW(), 1)")
        	->find();
    	
    	if ($event->count() > 0){
            $drivers = $event->getDriverss();
            
            foreach ($drivers as $driver){
                
            }
        
            $this->view->render($response, 'cron/users_reminder_car_organization.html',
                $outputVars);
        }
    }
	
}
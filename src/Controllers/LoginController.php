<?php
namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

use Propel\Runtime\Propel as Propel;
use Propel\Runtime\Exception\PropelException as PropelException;

use Montanari\Controllers\BaseController as BaseController;

use Montanari\Propel\Events as Event;
use Montanari\Propel\Map\EventsTableMap as EventMap;

use Montanari\Propel\Users as User;
use Montanari\Propel\Map\UsersTableMap as UserMap;
use Montanari\Propel\UsersQuery as UsersQuery;

use Montanari\Propel\UserSettings as Setting;

use Montanari\Propel\EventsQuery;

use Montanari\Propel\AppSettings as AppSetting;
use Montanari\Propel\AppSettingsQuery;



use Propel\Runtime\ActiveQuery\Criteria;

use Facebook\Facebook as Facebook;

use \DateTime;

class LoginController extends BaseController{

	public function index(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Carico la pagina di login');
        return $this->view->render($response, 'user/login.html');
    }
	
	public function newUserPage(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'user/new.html');
    }
	
	public function newUserSubscription(Request $request, Response $response, array $args)
    {
    	
    	$con = Propel::getWriteConnection(UserMap::DATABASE_NAME);
    	
		$data = $request->getParsedBody();
		$user = new User();
		$user->fill($data);
		$codeConfirm = $this->randomString(16);
		$user->setCodeConfirm($codeConfirm);
		$pw = md5($data["confermaPassword"]);
		
		$setting = new Setting();
		
		//$con->beginTransaction();
		try {
			
			if ($user->getPassword() == $pw){

				$user->save($con);
				$user->reload();
				
				$setting->setIdUser($user->getId());
				
				$setting->save();
				$setting->reload();
				$user->setUserSettings($setting);
				//$con->commit();
				
				$this->logger->addInfo('Registrazione effettuata per utente: '.$user->getUsername());
				
				$user->reload();
				
				$nominative = $user->getNome()." ".$user->getCognome();
				$mailMsg = "Ciao <b>$nominative</b>,<br />conferma la tua iscrizione cliccando su limk seguente<br />".
					"<a href='https://montanari.netsons.org/user/emailConfirm/$codeConfirm'>https://montanari.netsons.org/user/emailConfirm/$codeConfirm</a>";
				
				$this->sendMail($user, $mailMsg);
				
				
				$message = "Benveuto <b>$nominative</b>!,<br />Ti ho appena inviato una mail di conferma.<br />".
						"Controlla la tua posta elettronica e clicca sul link per verificare la tua registrazione ";
				return $this->view->render($response, 'blank.html', ['message' => $message]);
			}else{
				$this->logger->addError('Le password immesse non sono uguali');
				return $this->view->render($response, 'user/new.html', ['message' => 'Le password immesse non sono uguali', 'user' => $user]);
			}
		} catch (PropelException $pe) {
			$this->logger->addError($pe->__toString());
			$message = 'Errore: controllare i dati immessi';
			if (stripos($pe->__toString(), 'Integrity constraint violation')){
				$message = 'Username esistente!';
			}
			return $this->view->render($response, 'user/new.html', ['message' => $message, 'user' => $user]);
		} catch (PropelException $e) {
			//$con->rollback();
			$this->logger->addError('Si  verificato un errore durante il salvataggio di questo utente');
			return $this->view->render($response, 'common/error.html');
		}
        
    }
	
	public function login(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Login');
        
        $user = new User();
        $user->setUsername($request->getParsedBodyParam('username'));
        $user->setPassword($request->getParsedBodyParam('password'));
        
        $userFound = UsersQuery::create()
        	->filterByUsername($user->getUsername())
        	->filterByPassword(md5($user->getPassword()))
        	->findOne();
                
		if ($userFound != null){
			
			$this->logger->addInfo('User '.$userFound->getUsername().' found');
			
			$emailConfirm = $userFound->getEmailConfirm();
			$firstAccess = $userFound->getFirstAccess();
			
			if ($emailConfirm){
				$this->setLoggedUser($userFound);
				
				$this->logger->addInfo('User '.$userFound->getUsername().': confirmed');
				$this->logger->addInfo('User '.$userFound->getUsername().': first access: '.$firstAccess);
				
				if (isset($_SESSION['calledUri'])){
					
					$calledUri = $_SESSION['calledUri'];
					return $response->withRedirect($calledUri);
				}
				
				$outputVars = $this->loadEvents($userFound);
				
				$dateDiff = AppSettingsQuery::create()
    				->withColumn('DATEDIFF(CURRENT_TIMESTAMP, value)', 'dateDiff')
    				->filterByKeyName('last_event_update')
				    ->findOne();
				    
				//if ((int)$dateDiff->getVirtualColumn('dateDiff') > 30){
				if (true){
			        $this->logger->addInfo('Aggiorno la lista degli eventi visto che son passati pi di 30gg');
			        
			        $this->updateEventsFromFb();
			        
			        $eventUpdate = AppSettingsQuery::create()->findOneByKeyName('last_event_update');
			        $now = new \DateTime();
			        $eventUpdate->setValue($now->format('Y-m-d H:i:s'));
			        $eventUpdate->save();
			    }
			    
				return $this->view->render($response, 'user/personalarea.html', $outputVars);
			}else{
				$this->logger->addWarning('User '.$user->getUsername().': account not confirmed');
				return $this->view->render($response, 'user/email_not_confirm.html', ['user' => $userFound]);
			}
		}else{
			$this->logger->addError('User '.$user->getUsername().': not found');
			return $this->view->render($response, 'user/login.html', ['message' => 'Dati di accesso errati!']);
		}
    }
    
    public function emailConfirm(Request $request, Response $response, array $args)
    {
    	
    	$code_confirm = $args['code'];
    	
    	$userFound = UsersQuery::create()
	    	->findOneByCodeConfirm($code_confirm);
    	
    	if ($userFound != null){
    		$con = Propel::getWriteConnection(UserMap::DATABASE_NAME);
    		
    		$this->logger->addInfo('User '.$userFound->getUsername().' found');
    		$userFound->setEmailConfirm(1);
    		try{
    			$userFound->save($con);
    			
    			$outputVars = $this->loadEvents($userFound);
    			
    			$this->setLoggedUser($userFound);
    			return $this->view->render($response, 'user/personalarea.html', $outputVars);
    		} catch (PropelException $e) {
    			//$con->rollback();
    			$this->logger->addError('Si  verificato un errore durante la conferma della mail');
    			return $this->view->render($response, 'common/error.html');
    		}
    	}else{
    		$this->logger->addError('Codice di conferma non trovato');
    		return $response->withRedirect('/');
    	}
    	
    }
    
    public function logout(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Loguout');
        if (isset($_SESSION['loggedUser'])){
			unset($_SESSION['loggedUser']);
			unset($_SESSION['user_settings']);
			unset($_SESSION['calledUri']);
        }
		return $response->withRedirect('/');
    }
    
    private function updateEventsFromFb()
    {
        try {
            $args = [
                'app_id' => '168490580470612', // Replace {app-id} with your app id
                'app_secret' => '27d720a63d5f9d089e016d3334b83bbb',
                'default_graph_version' => 'v2.2',
            ];
            
            $fb = new Facebook($args);
            
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get(
                '/170891743266566/events',
                'EAACZAPcUya1QBAJX9TzTcDaXNpWdLtZCbbZAnvbe49Jgf7BlUZBpw1ZCHdGwxSJJa1aZBKJN30yBEsbLsXKMZA7s94J46muG3Yvu4r6CgNOCpArjto4w7Sb6ZBSaUpAxaf68TpDIlW7fltVZAgHl9JJw8ORkfSF62ZBjUAFiMYZBIBcKgZDZD'
                );
            
            $res = array();
            $i = 0;
            $today = new DateTime();
            
            $events = $response->getDecodedBody();
            
            foreach ($events['data'] as $graphNode) {
                $startTime = new \DateTime($graphNode['start_time']);
                if($today < $startTime){
                    $event = EventsQuery::create()->findOneById($graphNode['id']);
                    if ($event == null){
                        $event = new Event();
                    }
                    $event->setId($graphNode['id']);
                    $event->setIdFb($graphNode['id']);
                    $event->setName($graphNode['name']);
                    $event->setDescription($graphNode['description']);
                    $event->setEventDate($startTime);
                    /*
                     $picture = $graphNode->getPicture();
                     if ($picture != null){
                     $res[$i]['pic'] = $picture->getUrl();
                     }
                     */
                    $graphLocation = $graphNode['place']['location'];
                    $event->setMeetingPoint($graphLocation['latitude'].",".$graphLocation['longitude']);
                    $event->setMeetingPointName($graphNode['place']['location']['city']);
                    
                    $event->save();
                }
            }
            
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
    
    private function loadEvents(User $userFound){
        $driverEvents = EventsQuery::create('')
            ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
            ->useDriversQuery()
            ->filterByIdUser($userFound->getId(), Criteria::EQUAL)
            ->endUse()
            ->find();
        $outputVars['driverEvents'] = $driverEvents;
        
        $passengerEvents = EventsQuery::create()
            ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
            ->usePassengersQuery()
            ->filterByIdUser($userFound->getId(), Criteria::EQUAL)
            ->endUse()
            ->find();
        $outputVars['passengerEvents'] = $passengerEvents;
        
        $idsFb = array();
        
        foreach ($driverEvents as $eve){
            array_push($idsFb, $eve->getId());
        }
        
        foreach ($passengerEvents as $eve){
            array_push($idsFb, $eve->getId());
        }
        
        $otherEvents = \Montanari\Propel\Base\EventsQuery::create()
            ->where("Events.EventDate > ?", time() - 30 * 24 * 60 * 60)
            ->orderBy(EventMap::COL_EVENT_DATE)->
            _and()->filterBy("Id", $idsFb, Criteria::NOT_IN)
            ->find();
        
        $outputVars['otherEvents'] = $otherEvents;
        $outputVars['user'] = $userFound;
        
        return $outputVars;
    }
}
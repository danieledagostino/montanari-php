<?php
namespace Montanari\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Facebook\Facebook;

use Propel\Runtime\Propel as Propel;

use Montanari\Controllers\BaseController as BaseController;

use Montanari\Propel\Settings as Setting;
use Montanari\Propel\Map\SettingsTableMap as SettingMap;
use Montanari\Propel\SettingsQuery as SettingsQuery;
use Montanari\Propel\Map\SettingsTableMap;
use Propel\Runtime\Exception\PropelException;
use Montanari\Propel\Map\UsersTableMap;
use Montanari\Propel\UsersQuery;

class SettingController extends BaseController{

	public function index(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Carico le impostazioni per l\'utente: '.$this->getIdUser());
        
        $settings = \Montanari\Propel\SettingsQuery::create()->findByIdUser($this->getIdUser());
        
        $outputVars['setting'] = $settings->getFirst();
        $_SESSION['user_settings'] = $settings->getFirst();
        
        return $this->view->render($response, 'settings/notification.html', 
        		$outputVars);
    }
    
    public function save(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Salvo le impostazioni');
               
        $con = Propel::getWriteConnection(SettingMap::DATABASE_NAME);
        //$con->useDebug(true);
         
        $data = $request->getParsedBody();
        $setting = $this->getLoggedUser()->getUserSettings();
        $setting->fill($data);
        
        try {
       		$setting->save($con);
       		
       		$_SESSION['user_settings'] = $setting;
       		$outputVars['setting'] = $setting;
       		$outputVars['message'] = 'Impostazione salvate!';
       		
        } catch (PropelException $e) {
       		//$con->rollback();
       		$this->logger->addError('Si è verificato un errore durante il salvataggio di queste impostazioni');
       		return $this->view->render($response, 'common/error.html');
       	}
       		
        return $this->view->render($response, 'settings/notification.html', $outputVars);
    }
    
    public function password(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'settings/password.html');
    }
    
    public function savePassword(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Salvo le impostazioni');
        
        $con = Propel::getWriteConnection(UsersTableMap::DATABASE_NAME);
        
        $data = $request->getParsedBody();
        
        $user = $this->getLoggedUser();
        
        $pw = md5($data["password"]);
        $pw_rpt = md5($data["password_rpt"]);
        
        
        if ($pw == $pw_rpt){
            
            $user->setPassword($pw);
            
            try {
                $updated = $user->save();
                
                if ($updated == 1){
                    $message = 'Password modificata';
                }else{
                    $message = 'Errore: password non modificata';
                }
            } catch (PropelException $pe) {
                $this->logger->addError($pe->__toString());
                $message = 'Errore: '.$pe->getMessage();
            }
        }else{
            $message = 'Errore: le due password non sono uguali';
        }
        
        return $this->view->render($response, 'settings/password.html', ['message' => $message]);
    }
    
    public function recoveryPassword(Request $request, Response $response, array $args)
    {
        $this->logger->addInfo('Azzero la password');
        
        $message = '';
        
        $renderedUrl = 'settings/passwordRecovery.html';
        
        if ($request->getMethod() == 'GET'){
            return $this->view->render($response, $renderedUrl);
        }else if($request->getMethod() == 'POST') {
            $data = $request->getParsedBody();
            
            $email = $data['email'];
            
            try {
                $user = UsersQuery::create()->findOneByEmail($email);
                if ($user != null){
                    $user->setPassword(md5('123456'));
                    $codeConfirm = $this->randomString(16);
                    $user->setCodeConfirm($codeConfirm);
                    $user->setEmailConfirm(0);
                    $user->setFirstAccess(true);
                    
                    $updated = $user->save();
                    
                    if ($updated == 1){
                        $mailMsg = "Ciao <b>$user->fullName()</b>,<br />hai richiesto di resettare la password. Conferma cliccando su limk seguente<br />".
                            "<a href'https://montanari.netsons.org/user/emailConfirm/$codeConfirm'>https://montanari.netsons.org/user/emailConfirm/$codeConfirm</a>";
                        
                        $this->sendMail($user, $mailMsg);
                        
                        $message = 'Password resettata: controlla la tua e-mail';
                        
                        $renderedUrl = 'user/login.html';
                    }else{
                        $message = 'Errore password non resettata: contatta l\'amministratore';
                    }
                }else{
                    $message = 'Errore: utente non trovato';
                }
            } catch (PropelException $pe) {
                $this->logger->addError($pe->__toString());
                $message = 'Errore: '.$pe->getMessage();
            }
            
            return $this->view->render($response, $renderedUrl, ['message' => $message]);
        }
    }
}
<?php

namespace Montanari\Auth;

use Interop\Container\ContainerInterface;
use Slim\DeferredCallable;

class AuthCheck
{

    /**
     * @var \Interop\Container\ContainerInterface
     */
    private $container;
	private $logger;
	private $view;

    /**
     * OptionalAuth constructor.
     *
     * @param \Interop\Container\ContainerInterface $container
     *
     * @internal param \Slim\Middleware\JwtAuthentication $jwt
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
		$this->view = $container['view'];
		$this->logger = $container['logger'];
    }

    /**
     * OptionalAuth middleware invokable class to verify JWT token when present in Request
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {	
    	$loggedUser = null;
    	
    	if (isset($_SESSION['loggedUser'])){
    		$loggedUser = $_SESSION['loggedUser'];
    	}
    	
        if ($loggedUser == null) {
			$this->logger->addInfo('Utente non loggato');
			$uriCalled = $request->getUri()->getPath();
			
			$this->logger->addInfo('Uri chiamata: '.$uriCalled);
			
			if($uriCalled != '/user/login'){
				$_SESSION['calledUri'] = $uriCalled;
			}
            return $this->view->render($response, 'user/login.html');
        }else{
			$this->logger->addInfo('Utente loggato');
			$request = $request->withAttribute('user', $loggedUser);
	        return $next($request, $response);
		}

    }
}
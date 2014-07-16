<?php
namespace ReservePianoRoom;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface 
{
	public function onBootstrap(MvcEvent $e)
	{
		$application = $e->getApplication();
		$services    = $application->getServiceManager();
	}
	
	public function getAutoloaderConfig(){
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}
        
}
?>
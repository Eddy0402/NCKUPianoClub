<?php
namespace User;

use Zend\Math\Rand;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	
	public function getServiceConfig()
    {
        return array(
            'invokables' => array(
				'User\Authentication\Adapter\NCKUMail' => 'User\Authentication\Adapter\NCKUMail',
			),
		);
	}
			
	public function onBootstrap( MvcEvent $e)
    {
		$events = $e->getApplication()->getEventManager()->getSharedManager();
		$events->attach('ZfcUser\Form\Register','init', function($e) {
			$form = $e->getTarget();
			$form -> add(array(
				'name' => 'card_id',
				'options' => array(
					'label' => 'Card ID',
				),
				'attributes' => array(
					'type'  => 'Text',					
				),
			));
		});
		
		$events->attach('ZfcUser\Form\RegisterFilter','init', function($e) {
			$filter = $e->getTarget();	
			$filter -> remove('username');
			$filter -> add(array(
                'name'       => 'username',
                'required'   => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 2,
                            'max' => 128,
                        ),
                    ),
                    $filter->getUsernameValidator(),
                ),
            ));
			$filter -> remove('display_name');
			$filter->add(array(
                'name'       => 'display_name',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 2,
                            'max' => 128,
                        ),
                    ),
                ),
            ));
		});
	
		$em = \Zend\EventManager\StaticEventManager::getInstance();
        $em->attach('ZfcUser\Service\User', 'register', function($e) {
			$form = $e->getParam('form');
			$user = $e->getParam('user');
			$data = $form -> getData();
			$imap_return = imap_open('{mail.ncku.edu.tw/ssl/novalidate-cert}INBOX',$data->getUserName(),$data->getPassword());
			if(imap_ping($imap_return) == 1){
				$user->setPassword( Rand::getString(32, 'abcdefghijklmnopqrstuvwxyz0123456789_-.', true) );
				$user->setState('2');
			}else{
				$user->setState('1');
			}
			$user->setRole('0');
			$user->setCardId($data->getCardId());
		});
	
    }
}

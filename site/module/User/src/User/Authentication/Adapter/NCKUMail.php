<?php

namespace User\Authentication\Adapter;

use Zend\Authentication\Result as AuthenticationResult;
use ZfcUser\Authentication\Adapter\AbstractAdapter;
use ZfcUser\Authentication\Adapter\AdapterChainEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Session\Container as SessionContainer;
use ZfcUser\Mapper\HydratorInterface as Hydrator;
use ZfcUser\Mapper\UserInterface as UserMapper;
use ZfcUser\Options\AuthenticationOptionsInterface as AuthenticationOptions;

class NCKUMail extends AbstractAdapter implements ServiceManagerAwareInterface{
	
	protected $mapper;

    protected $hydrator;

    protected $serviceManager;

    protected $options;
	
	public function logout()
    {
        $this->getStorage()->clear();
    }

    public function authenticate(AdapterChainEvent $event)
    {
        if ($this->isSatisfied()) {
            $storage = $this->getStorage()->read();
            $event->setIdentity($storage['identity'])
                  ->setCode(AuthenticationResult::SUCCESS)
                  ->setMessages(array('Authentication successful.'));
            return;
        }

		
        $identity   = $event->getRequest()->getPost()->get('identity');
        $credential = $event->getRequest()->getPost()->get('credential');
			
        $userObject = $this->getMapper()->findByUsername($identity);

        if (!$userObject) {
            $event->setCode(AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND)
                  ->setMessages(array('A record with the supplied identity could not be found.'));
            $this->setSatisfied(false);
            return false;
        }

        if ($this->getOptions()->getEnableUserState()) {
            // Don't allow user to login if state is not in allowed list
            if (!in_array($userObject->getState(), $this->getOptions()->getAllowedLoginStates())) {
                $event->setCode(AuthenticationResult::FAILURE_UNCATEGORIZED)
                      ->setMessages(array('A record with the supplied identity is not active.'));
                $this->setSatisfied(false);
                return false;
            }
        }
		
		error_log('a');
		
		$imap_return = imap_open('{mail.ncku.edu.tw/ssl}INBOX',$identity,$credential);
		if(imap_ping($imap_return) != 1){		
		    $event->setCode(AuthenticationResult::FAILURE_CREDENTIAL_INVALID)
                  ->setMessages(array('Supplied credential is invalid.'));
            $this->setSatisfied(false);
            return false;
		}
					
		error_log('a');
		
        // regen the id
        SessionContainer::getDefaultManager()->regenerateId();

        // Success!
        $event->setIdentity($userObject->getId());

        $this->setSatisfied(true);
        $storage = $this->getStorage()->read();
        $storage['identity'] = $event->getIdentity();
        $this->getStorage()->write($storage);
        $event->setCode(AuthenticationResult::SUCCESS)
              ->setMessages(array('Authentication successful.'));
	}
	
	
    public function getMapper()
    {
        if (!$this->mapper instanceof UserMapper) {
            $this->setMapper($this->serviceManager->get('zfcuser_user_mapper'));
        }
        return $this->mapper;
    }

    public function setMapper(UserMapper $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    public function getHydrator()
    {
        if (!$this->hydrator instanceof Hydrator) {
            $this->setHydrator($this->serviceManager->get('zfcuser_user_hydrator'));
        }
        return $this->hydrator;
    }

    public function setHydrator(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function setOptions(AuthenticationOptions $options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        if (!$this->options instanceof AuthenticationOptions) {
            $this->setOptions($this->serviceManager->get('zfcuser_module_options'));
        }
        return $this->options;
    }
}
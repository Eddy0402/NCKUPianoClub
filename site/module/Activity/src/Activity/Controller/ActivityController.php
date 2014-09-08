<?php

namespace Activity\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ActivityController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

	public function postAction(){
		return new ViewModel();
	}
	
	public function contentAction(){
		return new ViewModel();
	}
}


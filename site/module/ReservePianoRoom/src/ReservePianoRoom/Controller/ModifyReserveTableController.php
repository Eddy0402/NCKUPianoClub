<?php

namespace ReservePianoRoom\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ModifyReserveTableController extends AbstractActionController
{
	public function insertAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
        
		$this -> redirect();
	}
}

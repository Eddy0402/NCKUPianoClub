<?php

namespace ReservePianoRoom\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ReservePianoRoom\Model\Record;

class ModifyReserveTableController extends AbstractActionController
{
	public function modifyAction(){
		
		if ($this->zfcUserAuthentication()->hasIdentity()) {
		
			$date = $this->params()->fromRoute('date');
			$class = (int) $this->params()->fromRoute('class', 0);
			$room = (int) $this->params()->fromRoute('room', 0);
			$cancel = $this->params()->fromRoute('cancel');

			$Table = $this-> getReserveTable();
			if(!$Table -> isRoomReserved($date,$class,$room)){
				$record = new Record();
				$record -> exchangeArray(array(
					'room' => $room,
					'date' => $date,
					'class' => $class,
					'uid' => $this->zfcUserAuthentication()->getIdentity()->getId(),					
				));
				$Table->saveRecord($record);
			}

			$response = $this->getResponse();
			$response->setContent('Success'); 
			return $response;
		
		}else{
			$response = $this->getResponse();
			$response->setContent('Not logged in.'); 
			return $response;
		}	
	}
	
	public function getReserveTable()
    {
         if (!$this->ReserveTable) {
             $sm = $this->getServiceLocator();
             $this->ReserveTable = $sm->get('ReservePianoRoom\Model\ReserveTable');
         }
         return $this->ReserveTable;
    }

	protected $ReserveTable;
}

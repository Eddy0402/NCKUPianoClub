<?php

namespace ReservePianoRoom\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ViewReserveTableDataController extends AbstractActionController
{
	public function viewAction(){
		$page = $this->params()->fromRoute('page',0);
		$room = $this->params()->fromRoute('room',0);
		
		$first = new \DateTime('this week');
		$last = new \DateTime('this week +6 days');
		
		$first->modify((string)($page * 7) . ' day');
		$last->modify((string)($page * 7) . 'day ');
	
        $viewModel = new ViewModel(array(
			'resultset' => $this-> getReserveTable() -> getRecordByDate($first -> format('y-m-d'),$last -> format('y-m-d')),
			'page' => $page,
			'first' => $first,
			'last' => $last,
			'room' => $room,
			'reservable' => ($page == "1" ? "true" : "false"),
		));
		
		$viewModel->setTerminal(true);
		return $viewModel;
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

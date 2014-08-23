<?php 

namespace ReservePianoRoom\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ReservePianoRoomController extends AbstractActionController{
	public function indexAction(){
        return new ViewModel(array(
			'users' => $this-> getUserTable() -> fetchAll(),
			//'users' => $this-> getUserTable() -> getUser(1),
		));
	}
	
	public function getUserTable()
    {
         if (!$this->userTable) {
             $sm = $this->getServiceLocator();
             $this->userTable = $sm->get('ReservePianoRoom\Model\UserTable');
         }
         return $this->userTable;
    }

	protected $userTable;
}
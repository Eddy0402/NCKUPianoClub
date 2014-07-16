<?php 

namespace ReservePianoRoom\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ReservePianoRoomController extends AbstractActionController{
	public function indexAction(){
                            return new ViewModel();
	}

}
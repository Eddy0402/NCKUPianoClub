<?php 

namespace ReservePianoRoom\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ViewReserveTableController extends AbstractActionController{
	public function viewAction(){
        return new ViewModel();
	}
}

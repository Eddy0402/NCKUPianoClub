<?php

namespace Activity\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Activity\Model\Post;

class ActivityController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

	public function postAction(){
		$sm = $sm = $this -> getServiceLocator();
		$form = $sm -> get('Activity\Form\NewPostForm');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($this->zfcUserAuthentication()->hasIdentity()) {
				error_log('123');
				$uid = $this->zfcUserAuthentication()->getIdentity()->getId();
				$post = new Post();
				$form->setData($request->getPost());
				if ($form->isValid()) {
					$post->exchangeArray($form->getData());
					$post->uid = $uid;
					$sm -> get('Activity\Model\PostTable')->savePost($post);
					return $this->redirect()->toRoute('activity/post');
				}
			}else{
								error_log('123ss');
				return $this->redirect()->toRoute('zfcuser/login');
			}
        }
		
		return new ViewModel(array(
			'form' => $form,
		));
	}
	
	public function contentAction(){
		return new ViewModel();
	}
	
	public function categoryAction(){
		return new ViewModel();
	}
}


<?php

namespace Activity\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Activity\Model\Post;
use Activity\Misc\Url;

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
				$uid = $this->zfcUserAuthentication()->getIdentity()->getId();
				$post = new Post();
				$form->setData($request->getPost());
				if ($form->isValid()) {
					$post->exchangeArray($form->getData());
					
					$post->uid = $uid;
					$post->url = Url::seoFriendlyUrl( $post -> title );
					
					$sm -> get('Activity\Model\PostTable')->savePost($post);
					return $this->redirect()->toRoute('activity/article',array(
						'article' => $post->url,
					));
				}
			}else{
				return $this->redirect()->toRoute('zfcuser/login');
			}
        }
		
		return new ViewModel(array(
			'form' => $form,
		));
	}
	
	public function articleAction(){
		$sm = $sm = $this -> getServiceLocator();
		$url = $this-> params() -> fromRoute('article');
		$table= $sm -> get('Activity\Model\PostTable');
		
		try{
			$post = $table->getPostByUrl( $url );
		}catch(\Exception $e){
			if($e->getMessage() == 'No such post'){
				return $this->redirect()->toRoute('activity');
			}
		}
		
		return new ViewModel(array(
			'post' => $post,
		));
	}
	
	public function categoryAction(){
		return new ViewModel();
	}
}


<?php

namespace Activity\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Activity\Model\Post;
use Activity\Misc\Url;

const PAGE_SIZE = 5;
    
class ActivityController extends AbstractActionController
{
    
    public function indexAction() {
        $page = $this -> params() -> fromRoute( 'page' );
        if($page <= 0){
            return $this -> redirect() -> toRoute( 'activity' );
        }
        $sm = $sm = $this -> getServiceLocator();
        $table = $sm -> get( 'Activity\Model\PostTable' );
        
        $dataSet = $table -> fetchAllInPage( $page, PAGE_SIZE );
        $pagecount = $table -> getPageCount( PAGE_SIZE );
        
        if(!$dataSet->current()){
            return $this -> redirect() -> toRoute( 'activity' );
        }

        return new ViewModel( array(
            'dataSet'   => $dataSet,
            'page'      => $page,
            'pagecount' => $pagecount,
        ) );
    }

    public function postAction() {
        $sm = $this -> getServiceLocator();
        $form = $sm -> get( 'Activity\Form\NewPostForm' );
        $request = $this -> getRequest();
        if ( $request -> isPost() ) {
            return $this -> saveArticle( $form, $request, $sm );
        } else {
            return new ViewModel( array(
                'form' => $form,
                'form_action' => 'post',
            ) );
        }
    }

    public function articleAction() {
        $sm = $sm = $this -> getServiceLocator();
        $url = $this -> params() -> fromRoute( 'article' );
        $table = $sm -> get( 'Activity\Model\PostTable' );

        try {
            $post = $table -> getPostByUrl( $url );
        } catch ( \Exception $ex ) {
            error_log( $ex -> getMessage() );
            return $this -> redirect() -> toRoute( 'activity' );
        }

        if ( !$post ) {
            return $this -> redirect() -> toRoute( 'activity' );
        }

        return new ViewModel( array(
            'post' => $post,
        ) );
    }

    public function editAction() {
        $sm = $sm = $this -> getServiceLocator();
        $url = $this -> params() -> fromRoute( 'article' );
        $table = $sm -> get( 'Activity\Model\PostTable' );
        $form = $sm -> get( 'Activity\Form\NewPostForm' );
        $request = $this -> getRequest();
        if ( $request -> isPost() ) {
            return $this -> saveArticle( $form, $request, $sm );
        } else {
            try {
                $post = $table -> getPostByUrl( $url );
            } catch ( \Exception $ex ) {
                error_log( $ex -> getMessage() );
                return $this -> redirect() -> toRoute( 'activity' );
            }
            if ( !$post ) {
                return $this -> redirect() -> toRoute( 'activity' );
            }
            $form -> bind( $post );
            $view = new ViewModel( array(
                'form' => $form,
                'form_action' => 'edit',
            ) );
            $view -> setTemplate( 'activity/activity/post.phtml' );
            return $view;
        }
    }

    private function saveArticle( $form, $request, $sm ) {
        if ( $this -> zfcUserAuthentication() -> hasIdentity() ) {
            $uid = $this -> zfcUserAuthentication() -> getIdentity() -> getId();
            $post = new Post();
            $form -> setData( $request -> getPost() );
            if ( $form -> isValid() ) {
                $post -> exchangeArray( $form -> getData() );

                $post -> uid = $uid;
                $post -> url = Url::seoFriendlyUrl( $post -> title );

                $sm -> get( 'Activity\Model\PostTable' ) -> savePost( $post );
                return $this -> redirect() -> toRoute( 'activity/article', array(
                        'article' => $post -> url,
                ) );
            }
        } else {
            return $this -> redirect() -> toRoute( 'zfcuser/login' );
        }
    }

    public function categoryAction() {
        return new ViewModel();
    }

}

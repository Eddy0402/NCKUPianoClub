<?php

namespace Activity\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class PostTable
{
	protected $tableGateway;

	public function __construct( TableGateway $tableGateway ) {
		$this -> tableGateway = $tableGateway;
	}

	public function fetchAll() {
		$resultSet = $this -> tableGateway -> select();
		return $resultSet -> buffer();
	}

	public function getPostByUrl( $url ) {
		$resultSet = $this -> tableGateway -> select( function(Select $select)use($url) {
			$select -> where( array(
				'url' => $url,
			));
		});	
		if(!$resultSet -> current()){
			throw new \Exception('No such post');
		}
		return $resultSet -> current();
	}
	
	public function getPostById( $id ) {
		$resultSet = $this -> tableGateway -> select( function(Select $select)use($id) {
			$select -> where( array(
				'id' => $id,
			));
		});		
		return $resultSet -> current();
	}
	

	public function savePost( Post $post ) {
		$data = array(
			'uid' => (int)$post -> uid,
			'category' => $post -> category,
			'title' => $post -> title,
			'content' => $post -> content,
			'sticky_posts' => (int)$post -> sticky_posts,
			'url' => $post -> url,
		);
		//TODO: check if update
		$this -> tableGateway -> insert( $data );
	}

	public function deleteRecord( Post $post ) {
		$this -> tableGateway -> delete( array( 'id' => $post->id ) );	
	}

}

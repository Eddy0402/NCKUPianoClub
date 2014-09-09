<?php

namespace Activity\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Predicate\Between;
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

	public function getPostByDate( $dateStart, $dateEnd ) {
		$resultSet = $this -> tableGateway -> select( function(Select $select)use($dateStart, $dateEnd) {
			$select -> where( array(
				new Between( 'date', $dateStart, $dateEnd ),
			));
			$select -> order( 'class asc,date asc' );
			$select -> join( 'user', 'user_id = ReserveTable.uid' );
		} );
		return $resultSet; //-> current();
	}

	public function getSingleRecord( $date, $class, $room ) {
		$resultSet = $this -> tableGateway -> select(
			array( 'date' => $date, 'class' => $class, 'room' => $room )
		);
		return $resultSet -> current();
	}

	public function savePost( Post $post ) {
		$data = array(
			'uid' => $post -> uid,
			'category' => $post -> category,
			'title' => $post -> title,
			'content' => $post -> content,
			'sticky_posts' => $post -> sticky_posts,
		);
		//TODO: check if update
		$this -> tableGateway -> insert( $data );
	}

	public function deleteRecord( Record $record ) {
		$this -> tableGateway -> delete( array( 
			'room' => $record -> room,
			'date' => $record -> date,
			'class' => $record -> class,			
		) );
	}

}

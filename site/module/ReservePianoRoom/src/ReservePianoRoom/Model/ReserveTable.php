<?php

namespace ReservePianoRoom\Model;

use Zend\Db\TableGateway\TableGateway;

class ReserveTable
{

	protected $tableGateway;

	public function __construct( TableGateway $tableGateway ) {
		$this -> tableGateway = $tableGateway;
	}

	public function fetchAll() {
		$resultSet = $this -> tableGateway -> select();
		return $resultSet ->  buffer();
	}

	public function getRecordByDate( $dateStart, $dateEnd ) {
		$resultSet = $this -> tableGateway -> select( function(\Zend\Db\Sql\Select $select)use($dateStart,$dateEnd){
			$select -> where(function(\Zend\Db\Sql\Where $where)use($dateStart,$dateEnd){
				$where-> between('date',$dateStart,$dateEnd);					
			}) ;
			$select -> order('class asc,date asc');
		}) ;
		return $resultSet;//-> current();
	}
	
	public function getSingleRecord( Date $date, $class, $room ) {
		$resultSet = $this -> tableGateway -> select(
			array( 'date' => $date, 'class' => $class, 'room' => $room ) 
		);
		return $resultSet -> current();
	}

	public function saveRecord( Record $record ) {
		$data = array(
			'reserve_id' => $record -> reserve_id,
			'room' => $record -> room,
			'date' => $record -> date,
			'class' => $record -> class,
			'uid' => $record ->uid,
			'flag' => $record -> flag,
			'comment' => $record -> comment,
		);

		if ( $this -> getSingleRecord( $record ->date, $record->class, $record->room ) ) {
			$this -> tableGateway -> update( $data, array( 
				'date' => $record->date, 'class' => $record->class, 'room' => $record->room )
			);
		} else {
			$this -> tableGateway -> insert( $data );
		}
	}
/*
	public function deleteUser( $uid ) {
		$this -> tableGateway -> delete( array( 'uid' => ( int ) $uid ) );
	}
*/
}

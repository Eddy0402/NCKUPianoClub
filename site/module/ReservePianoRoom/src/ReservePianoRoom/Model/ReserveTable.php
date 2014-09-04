<?php

namespace ReservePianoRoom\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Predicate\Between;
use Zend\Db\Sql\Select;

class ReserveTable
{

	protected $tableGateway;

	public function __construct( TableGateway $tableGateway ) {
		$this -> tableGateway = $tableGateway;
	}

	public function fetchAll() {
		$resultSet = $this -> tableGateway -> select();
		return $resultSet -> buffer();
	}

	public function getRecordByDate( $dateStart, $dateEnd ) {
		$resultSet = $this -> tableGateway -> select( function(Select $select)use($dateStart, $dateEnd) {
			$select -> where( array(
				new Between( 'date', $dateStart, $dateEnd ),
			));
			$select -> order( 'class asc,date asc' );
			$select -> join( 'user', 'user_id = ReserveTable.uid' );
		} );
		return $resultSet; //-> current();
	}

	public function isRoomReserved( $date, $class, $room ) {
		if ( $this -> getSingleRecord( $date, $class, $room ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function getSingleRecord( $date, $class, $room ) {
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
			'uid' => $record -> uid,
			'flag' => $record -> flag,
			'comment' => $record -> comment,
		);
		$r = $this -> getSingleRecord( $record -> date, $record -> class, $record -> room );
		if ( $r ) {
			deleteRecord( $r -> reserve_id );
		}
		$this -> tableGateway -> insert( $data );
	}

	public function deleteRecord( $reserve_id ) {
		$this -> tableGateway -> delete( array( 'reserve_id' => ( int ) $reserve_id ) );
	}

}

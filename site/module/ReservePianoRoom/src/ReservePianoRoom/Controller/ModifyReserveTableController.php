<?php

namespace ReservePianoRoom\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ReservePianoRoom\Model\Record;

class ModifyReserveTableController extends AbstractActionController
{

	public function modifyAction() {
		if ( $this -> zfcUserAuthentication() -> hasIdentity() ) {

			$date = $this -> params() -> fromRoute( 'date' );
			$class = ( int ) $this -> params() -> fromRoute( 'class', 0 );
			$room = ( int ) $this -> params() -> fromRoute( 'room', 0 );
			$method = $this -> params() -> fromRoute( 'method' );

			$Table = $this -> getReserveTable();
			if ( $Table -> isRoomReserved( $date, $class, $room ) == false ) {
				$this -> AddRecord(
					$Table, $date, $class, $room, $this -> zfcUserAuthentication() -> getIdentity() -> getId()
				);
			}

			$response = $this -> getResponse();
			$response -> setContent( 'Success' );
			return $response;
		} else {
			$response = $this -> getResponse();
			$response -> setContent( 'Not logged in.' );
			return $response;
		}
	}

	private function AddRecord( $Table, $date, $class, $room, $uid ) {
		$record = new Record();
		$record -> exchangeArray( array(
			'date' => $date,
			'class' => $class,
			'room' => $room,
			'uid' => $uid,
		) );
		$Table -> saveRecord( $record );
	}

	public function getReserveTable() {
		if ( !$this -> ReserveTable ) {
			$sm = $this -> getServiceLocator();
			$this -> ReserveTable = $sm -> get( 'ReserveTable' );
		}
		return $this -> ReserveTable;
	}

	protected $ReserveTable;

}

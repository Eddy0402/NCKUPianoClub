<?php

namespace ReservePianoRoom\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable
{

	protected $tableGateway;

	public function __construct( TableGateway $tableGateway ) {
		$this -> tableGateway = $tableGateway;
	}

	public function fetchAll() {
		$resultSet = $this -> tableGateway -> select();
		return $resultSet;
	}

	public function getUser( $uid ) {
		$uid = ( int ) $uid;
		$row = $this -> tableGateway -> select( array( 'uid' => $uid ) ) -> current();
		if ( !$row ) {
			throw new Exception( "User not found!" );
		}
		return $row;
	}

	public function saveUser( User $user ) {
		$data = array(
			'uid' => $user -> artist,
			'name' => $user -> title,
			'password' => $user -> password,
			'password_salt' => $user -> password_salt,
			'auth_method' => $user -> auth_method,
			'privilege' => $user -> privilege,
		);

		$uid = ( int ) $user -> uid;
		if ( $uid == 0 ) {
			$this -> tableGateway -> insert( $data );
		} else {
			if ( $this -> getUser( $uid ) ) {
				$this -> tableGateway -> update( $data, array( 'uid' => $uid ) );
			} else {
				throw new \Exception( 'User not found!' );
			}
		}
	}

	public function deleteUser( $uid ) {
		$this -> tableGateway -> delete( array( 'uid' => ( int ) $uid ) );
	}

}

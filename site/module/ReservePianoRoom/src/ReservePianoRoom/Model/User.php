<?php

namespace ReservePianoRoom\Model;

class User
{

	public $uid = 0;
	public $name;
	public $password;
	public $password_salt;
	public $auth_method;
	public $privilege;

	public function exchangeArray( $data ) {
		$this -> uid = (!empty( $data[ 'uid' ] )) ? $data[ 'uid' ] : null;
		$this -> name= (!empty( $data[ 'name' ] )) ? $data[ 'name' ] : null;
		$this -> password = (!empty( $data[ 'password' ] )) ? $data[ 'password' ] : null;
		$this -> password_salt = (!empty( $data[ 'password_salt' ] )) ? $data[ 'password_salt' ] : null;
		$this -> auth_method = (!empty( $data[ 'auth_method' ] )) ? $data[ 'auth_method' ] : null;
		$this -> privilege = (!empty( $data[ 'privilege' ] )) ? $data[ 'privilege' ] : null;
	}

}

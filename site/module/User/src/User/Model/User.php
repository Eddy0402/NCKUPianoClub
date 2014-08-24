<?php

namespace User\Model;

class User implements \ZfcUser\Entity\UserInterface
{

	public $uid = 0;
	public $name;
	public $email;
	public $password;
	public $password_salt;
	public $auth_method;
	public $privilege;
	public $state;
/*
	public function exchangeArray( $data ) {
		$this -> uid = (!empty( $data[ 'uid' ] )) ? $data[ 'uid' ] : null;
		$this -> name= (!empty( $data[ 'name' ] )) ? $data[ 'name' ] : null;
		$this -> email= (!empty( $data[ 'email' ] )) ? $data[ 'email' ] : null;
		$this -> password = (!empty( $data[ 'password' ] )) ? $data[ 'password' ] : null;
		$this -> password_salt = (!empty( $data[ 'password_salt' ] )) ? $data[ 'password_salt' ] : null;
		$this -> auth_method = (!empty( $data[ 'auth_method' ] )) ? $data[ 'auth_method' ] : null;
		$this -> privilege = (!empty( $data[ 'privilege' ] )) ? $data[ 'privilege' ] : null;
	}*/

	public function getDisplayName() {
		return $this -> name;
	}

	public function getEmail() {
		return $this -> email;
	}

	public function getId() {
		return $this -> uid;
	}

	public function getPassword() {
		return $this -> password;
	}

	public function getState() {
		return $this -> state;
	}

	public function getUsername() {
		return $this -> name;
	}
	
	public function setDisplayName($name) {
		$this -> name = $name;
		return $this;
	}

	public function setEmail($email) {
		$this -> email = $email;
		return $this;
	}

	public function setId($uid) {
		$this -> uid = $uid;
		return $this;
	}

	public function setPassword($password) {
		$this -> password = $password;
		return $this;
	}

	public function setState($state) {
		$this -> state = $state;
		return $this;
	}

	public function setUsername($name) {
		$this -> name = $name;
		return $this;
	}

}

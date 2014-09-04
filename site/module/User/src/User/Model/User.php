<?php

namespace User\Model;

class User implements \ZfcUser\Entity\UserInterface
{

	private $uid = 0;
	private $name;
	private $displayName;
	private $email;
	private $password;
	private $state;
	private $role;
	
	public function exchangeArray( $data ) {
		$this -> uid = (!empty( $data[ 'user_id' ] )) ? $data[ 'user_id' ] : null;
		$this -> name = (!empty( $data[ 'username' ] )) ? $data[ 'username' ] : null;
		$this -> displayName = (!empty( $data[ 'display_name' ] )) ? $data[ 'display_name' ] : null;
		$this -> email = (!empty( $data[ 'email' ] )) ? $data[ 'email' ] : null;
		$this -> state = (!empty( $data[ 'state' ] )) ? $data[ 'state' ] : null;
		$this -> role = (!empty( $data[ 'role' ] )) ? $data[ 'role' ] : null;
	}

	public function getDisplayName() {
		return $this -> displayName;
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
		
	public function getRole(){
		return $this -> role;
	}
	
	public function setDisplayName($name) {
		$this -> displayName = $name;
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
	
	public function setRole($role){
		$this -> role = $role;
		return $this;
	}
}

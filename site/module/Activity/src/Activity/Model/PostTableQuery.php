<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Activity\Model;

/**
 * Description of PostTableQuery
 *
 * @author eddy
 */
class PostTableQuery
{

	protected $dbAdapter;

	public function __construct( Adapter $dbAdapter ) {
		$this -> dbAdapter = $dbAdapter;
	}
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Activity\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

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
    
    public function getCategoryId($title){
        $sql = new Sql( $this -> dbAdapter );
		$select = $sql -> select();
		$select -> columns( array('id') );
		$select -> where( array(
			'title' => $title,
		) );
		$select -> from( 'activity_category' );
		return $sql -> prepareStatementForSqlObject( $select ) -> execute() -> current()[ 'id' ];
    }
}

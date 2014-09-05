<?php

namespace ReservePianoRoom\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Between;

class ReserveTableQuery
{

	protected $dbAdapter;

	public function __construct( Adapter $dbAdapter ) {
		$this -> dbAdapter = $dbAdapter;
	}

	public function getPersonReservedCount( $uid, $dateStart, $dateEnd ) {
		$sql = new Sql( $this -> dbAdapter );
		$select = $sql -> select();
		$select -> columns( array( 'num' => new Expression( 'COUNT(*)' ) ) );
		$select -> where( array(
			'uid' => $uid,
			new Between( 'date', $dateStart, $dateEnd ),
		) );
		$select -> from( 'ReserveTable' );
		return $sql -> prepareStatementForSqlObject( $select ) -> execute() -> current()[ 'num' ];
	}

	public function isPersonReservedInTime($uid, $date, $class){
		$sql = new Sql( $this -> dbAdapter );
		$select = $sql -> select();
		$select -> columns( array( 'num' => new Expression( 'COUNT(*)' ) ) );
		$select -> where( array(
			'uid' => $uid,
			'date' => $date,
			'class' => $class,
		) );
		$select -> from( 'ReserveTable' );
		if($sql -> prepareStatementForSqlObject( $select ) -> execute() -> current()[ 'num' ] > 0){
			return true;
		}else{
			return false;
		}
	}
}

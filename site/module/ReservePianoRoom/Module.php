<?php
namespace ReservePianoRoom;

use ReservePianoRoom\Model\Record;
use ReservePianoRoom\Model\ReserveTable;
use ReservePianoRoom\Model\ReserveTableQuery;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module 
{
	public function getAutoloaderConfig(){
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}
       
	public function getServiceConfig(){
		return array(
			'factories' => array(
				'ReservePianoRoom\Model\ReserveTable' => function($sm) {
					$tableGateway = $sm -> get('ReservePianoRoom\Model\ReserveTableGateway');
					return $table = new ReserveTable($tableGateway);
				},
				'ReservePianoRoom\Model\ReserveTableGateway' => function($sm){
					$dbAdapter = $sm -> get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype ->setArrayObjectPrototype(new Record());
					return new TableGateway('ReserveTable',$dbAdapter,null,$resultSetPrototype);
				},
				'ReservePianoRoom\Model\ReserveTableQuery' => function($sm){
					$dbAdapter = $sm -> get('Zend\Db\Adapter\Adapter');
					return new ReserveTableQuery($dbAdapter);
				},
			),
		);
	}
}

<?php
namespace ReservePianoRoom;

use ReservePianoRoom\Model\User;
use ReservePianoRoom\Model\UserTable;
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
				'ReservePianoRoom\Model\UserTable' => function($sm) {
					$tableGateway = $sm -> get('UserTableGateway');
					$table = new UserTable($tableGateway);
					return $table;
				},
				'UserTableGateway' => function($sm){
					$dbAdapter = $sm -> get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype ->setArrayObjectPrototype(new User());
					return new TableGateway('UserTable',$dbAdapter,null,$resultSetPrototype);
				},
			),
		);
	}
}

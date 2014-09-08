<?php

namespace Activity;

use Activity\Model\Post;
use Activity\Model\PostTable;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	public function getServiceConfig(){
		return array(
			'factories' => array(
				'Activity\Model\PostTable' => function($sm) {
					$tableGateway = $sm -> get('ReservePianoRoom\Model\ReserveTableGateway');
					return $table = new PostTable($tableGateway);
				},
				'Activity\Model\PostTableGateway' => function($sm){
					$dbAdapter = $sm -> get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype ->setArrayObjectPrototype(new Post());
					return new TableGateway('activity',$dbAdapter,null,$resultSetPrototype);
				},
				'Activity\Model\PostTableQuery' => function($sm){
					$dbAdapter = $sm -> get('Zend\Db\Adapter\Adapter');
					return new PostTableQuery($dbAdapter);
				},
			),
			'invokables' => array(
				'Activity\Form\NewPostForm' => 'Activity\Form\NewPostForm',
			),
		);
	}
}

<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'ReservePianoRoom\Controller\ReservePianoRoom' => 'ReservePianoRoom\Controller\ReservePianoRoomController',
		),
	),
	
	'router' => array(
		'routes' => array(
			'ReservePianoRoom' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/ReservePianoRoom[/][:action]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					),
					'defaults' => array(
						'controller' => 'ReservePianoRoom\Controller\ReservePianoRoom',
						'action' => 'index',
					),
				),
			),
		),	
	),
	
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		/*'template_map' => array(
			'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
		),*/
		'template_path_stack' => array(
			'reservepianoroom' => __DIR__ . '/../view',
		),
	),
);
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
		'template_path_stack' => array(
			'reservepianoroom' => __DIR__ . '/../view',
		),
	),
);
<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'ReservePianoRoom\Controller\ViewReserveTable' => 'ReservePianoRoom\Controller\ViewReserveTableController',
			'ReservePianoRoom\Controller\ViewReserveTableData' => 'ReservePianoRoom\Controller\ViewReserveTableDataController',
			'ReservePianoRoom\Controller\ModifyReserveTable' => 'ReservePianoRoom\Controller\ModifyReserveTableController',
		),
	),
	
	'translator' => array(
		'translation_file_patterns' => array(
			array(
				'type' => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern' => '%s.mo',
			),
		),
		'locale' => 'zh_TW',
	),
	
	'router' => array(
		'routes' => array(
			'ViewReserveTable' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/ReservePianoRoom/',
					'defaults' => array(
						'controller' => 'ReservePianoRoom\Controller\ViewReserveTable',
						'action' => 'index',
					),
				),
			),
			'ViewReserveTableTable' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/ReservePianoRoom/page/:page/[room/:room/]',
					'constraints' => array(
						'page'   => '[-0-9]*',
						'room'   => '[1-3]',
					),
					'defaults' => array(
						'controller' => 'ReservePianoRoom\Controller\ViewReserveTable',
						'action' => 'view',
						'page' => 0,
						'room' => 1,
					),
				),
			),
			'ModifyReserveTable' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/ReservePianoRoom/m/d/:date/c/:class/r/:room/[c/:cancel/]',
					'constraints' => array(
						'date'   => '[-0-9]*',
						'class'  => '[0-9]+',
						'room'   => '[1-3]+',
						'cancel' => '[a-z]+',
					),
					'defaults' => array(
						'controller' => 'ReservePianoRoom\Controller\ModifyReserveTable',
						'action' => 'modify',
						'cancel' => 'false',
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
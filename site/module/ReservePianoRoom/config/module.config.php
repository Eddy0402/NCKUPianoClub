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
						'action' => 'view',
					),
				),
			),
			'ViewReserveTableData' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/ReservePianoRoom/page/:page/',
					'constraints' => array(
						'page'   => '[-0-9]*',
					),
					'defaults' => array(
						'controller' => 'ReservePianoRoom\Controller\ViewReserveTableData',
						'action' => 'view',
						'page' => 0,
					),
				),
			),
			'ModifyReserveTable' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/ReservePianoRoom/insert[/]',
					'defaults' => array(
						'controller' => 'ReservePianoRoom\Controller\ModifyReserveTable',
						'action' => 'insert',
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
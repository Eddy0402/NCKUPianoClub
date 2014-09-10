<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'Activity\Controller\Activity' => 'Activity\Controller\ActivityController'
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
			'activity' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/activity',
					'defaults' => array(
						'controller' => 'Activity\Controller\Activity',
						'action' => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'post' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => '/post',
							'defaults' => array(
								'controller' => 'Activity\Controller\Activity',
								'action' => 'post',
							),
						),
					),
					'edit' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/edit/:article',
							'constraints' => array(
								'article' => '[^/]*',
							),
							'defaults' => array(
								'controller' => 'Activity\Controller\Activity',
								'action' => 'edit',
							),
						),
					),
					'article' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/article/:article',
							'constraints' => array(
								'article' => '[^/]*',
							),
							'defaults' => array(
								'controller' => 'Activity\Controller\Activity',
								'action' => 'article',
							),
						),
					),
					'category' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/category/:category',
							'constraints' => array(
								'category' => '[^/]*',
							),
							'defaults' => array(
								'controller' => 'Activity\Controller\Activity',
								'action' => 'category',
							),
						),
					),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'activity' => __DIR__ . '/../view',
		),
	),
);

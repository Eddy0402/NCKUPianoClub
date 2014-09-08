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
					'content' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/:year/:month/:date/:article',
							'constraints' => array(
								'year' => '[0-9]*',
								'month' => '[0-9]*',
								'date' => '[0-9]*',
								'article' => '[-a-zA-Z0-9]*',
							),
							'defaults' => array(
								'controller' => 'Activity\Controller\Activity',
								'action' => 'content',
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

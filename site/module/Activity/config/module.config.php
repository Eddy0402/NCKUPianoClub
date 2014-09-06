<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Activity\Controller\Activity' => 'Activity\Controller\ActivityController'
		),
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
			),
		),
	),
	'view_manager' => array(
        'template_path_stack' => array(
            'activity' => __DIR__ . '/../view',
        ),
    ),
);
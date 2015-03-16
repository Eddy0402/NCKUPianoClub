<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action' => 'index',
					),
				),
			),
			'about' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/about',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action' => 'about',
					),
				),
			),
			'borrow' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/borrow',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action' => 'borrow',
					),
				),
			),
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
	'controllers' => array(
		'invokables' => array(
			'Application\Controller\Index' => 'Application\Controller\IndexController'
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
			'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
			'layout/loginwidget' => __DIR__ . '/../view/layout/loginwidget.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404' => __DIR__ . '/../view/error/404.phtml',
			'error/index' => __DIR__ . '/../view/error/index.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);

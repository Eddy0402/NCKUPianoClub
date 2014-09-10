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
                'type' => 'Segment',
                'options' => array(
                    'route' => '/activity',
                    'defaults' => array(
                        'controller' => 'Activity\Controller\Activity',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'page' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Activity\Controller\Activity',
                                'action' => 'index',
                                'template' => 'index',
                                'page' => '1',
                            ),
                        ),
                    ),
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
                            'route' => '/category/:category[/:page]',
                            'constraints' => array(
                                'category' => '[^/]*',
                                'page' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Activity\Controller\Activity',
                                'action' => 'category',
                                'page' => '1',
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

<?php

declare(strict_types=1);

namespace Catastro;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\HomeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller'    => Controller\HomeController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'contribuyente' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/contribuyente',
                    'defaults' => [
                        'controller' => Controller\ContribuyenteController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'agregar' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/agregar',
                            'defaults' => [
                                'action' => 'add',
                            ],
                        ],
                    ],
                    'ver' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/ver[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'view',
                            ],
                        ],
                    ],
                    'editar' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/editar[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'edit',
                            ],
                        ],
                    ],
                    'eliminar' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/eliminar[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'delete',
                            ],
                        ],
                    ],
                    'agregar_ajax' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/agregar_ajax',
                            'defaults' => [
                                'action' => 'addAjax',
                            ],
                        ],
                    ],
                    'ver_ajax' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/ver_ajax[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'viewAjax',
                            ],
                        ],
                    ],
                    'editar_ajax' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/editar_ajax[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'editAjax',
                            ],
                        ],
                    ],
                    'buscar_ajax' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/buscar_ajax[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'searchAjax',
                            ],
                        ],
                    ],
                    'pdf' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/pdf',
                            'defaults' => [
                                'action' => 'pdf',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\HomeController::class => Controller\Factory\HomeControllerFactory::class,
            Controller\ContribuyenteController::class => Controller\Factory\ContribuyenteControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\PostManager::class => Service\Factory\PostManagerFactory::class,
        ]
    ],
    // The following registers the session container for storing language settings.
    'session_containers' => [
        'I18nSessionContainer'
    ],
    'view_manager' => [
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => [
            'catastro' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '\..\src\\'],
            ],
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                __NAMESPACE__ . '\Entities' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];

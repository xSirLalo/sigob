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
            'catastro' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/catastro[/:action]',
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
                    'pdf' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/pdf',
                            'defaults' => [
                                'action' => 'pdf',
                            ],
                        ],
                    ],
                    'excel' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/excel',
                            'defaults' => [
                                'action' => 'excel',
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
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'options' => [
            // The access filter can work in 'restrictive' (recommended) or 'permissive'
            // mode. In restrictive mode all controller actions must be explicitly listed
            // under the 'access_filter' config key, and access is denied to any not listed
            // action for not logged in users. In permissive mode, if an action is not listed
            // under the 'access_filter' key, access to it is permitted to anyone (even for
            // not logged in users. Restrictive mode is more secure and recommended to use.
            'mode' => 'restrictive'
        ],
        'controllers' => [
            Controller\HomeController::class => [
                ['actions' => ['index'], 'allow' => '*'],
            ],
            Controller\ContribuyenteController::class => [
                ['actions' => ['index', 'add', 'view', 'edit', 'delete', 'pdf', 'excel'], 'allow' => '+contribuyente.manage']
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            Service\ContribuyenteManager::class => Service\Factory\ContribuyenteFactory::class,
        ]
    ],
    'view_manager' => [
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
                __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];

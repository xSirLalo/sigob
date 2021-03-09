<?php

declare(strict_types=1);

namespace Catastro;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

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
            'prueba' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/prueba',
                    'defaults' => [
                        'controller' => Controller\PruebaController::class,
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
                    'datatable' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/datatable',
                            'defaults' => [
                                'action' => 'datatable',
                            ],
                        ],
                    ],
                    'buscar' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/buscar[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'search',
                            ],
                        ],
                    ],
                ],
            ],
            'predio' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/predio',
                    'defaults' => [
                        'controller' => Controller\PredioController::class,
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
                    'buscarCatastral' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/buscarCatastral[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'searchCatastral',
                            ],
                        ],
                    ],
                    'autorellenaCatastral' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/autorellenaCatastral[/:id]',
                            'constraints' => [
                                'id' => '[0-9,-]+',
                            ],
                            'defaults' => [
                                'action' => 'autofillCatastral',
                            ],
                        ],
                    ],
                ],
            ],
            'biblioteca' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/biblioteca',
                    'defaults' => [
                        'controller' => Controller\BibliotecaController::class,
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
                    'eliminar-archivo' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/eliminar-archivo[/:contribuyente[/:archivo]]',
                            'constraints' => [
                                'contribuyente' => '[0-9]+',
                                'archivo' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'deleteFile',
                            ],
                        ],
                    ],
                    'imprimir-archivo' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/imprimir-archivo[/:contribuyente[/:archivo]]',
                            'constraints' => [
                                'contribuyente' => '[0-9]+',
                                'archivo' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'downloadFile',
                            ],
                        ],
                    ],
                ],
            ],
            'categoria' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/categoria',
                    'defaults' => [
                        'controller' => Controller\BibliotecaCategoriaController::class,
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
                ],
            ],
            'aportacion' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/aportacion',
                    'defaults' => [
                        'controller' => Controller\AportacionController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'nueva-aportacion' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/nueva-aportacion[/:id]',
                            'constraints' => [
                                'id' => '[0-9,a-z,A-Z,-]+',
                            ],
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
                    'validacion' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/validacion[/:id]',
                            'constraints' => [
                                'slug' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'validation',
                            ],
                        ],
                    ],
                    'datatable' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/datatable',
                            'defaults' => [
                                'action' => 'datatable',
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
                    'buscarRfc' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/buscarRfc[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'searchRfc',
                            ],
                        ],
                    ],
                    'autorellaRfc' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/autorellaRfc[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'autofillRfc',
                            ],
                        ],
                    ],
                    'buscarCatastral' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/buscarCatastral[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'searchCatastral',
                            ],
                        ],
                    ],
                    'autorellenaCatastral' => [
                        'type' => 'segment',
                        'options' => [
                                'route' => '/autorellenaCatastral[/:id]',
                                'constraints' => [
                                    'id' => '[0-9,-]+',
                                ],
                            'defaults' => [
                                'action' => 'autofillCatastral',
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
            Controller\PruebaController::class => Controller\Factory\PruebaControllerFactory::class,
            Controller\ContribuyenteController::class => Controller\Factory\ContribuyenteControllerFactory::class,
            Controller\PredioController::class => Controller\Factory\PredioControllerFactory::class,
            Controller\BibliotecaController::class => Controller\Factory\BibliotecaControllerFactory::class,
            Controller\BibliotecaCategoriaController::class => Controller\Factory\BibliotecaCategoriaControllerFactory::class,
            Controller\AportacionController::class => Controller\Factory\AportacionControllerFactory::class,
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
            Controller\PruebaController::class => [
                ['actions' => ['index', 'add'], 'allow' => '*'],
            ],
            Controller\ContribuyenteController::class => [
                ['actions' => ['index', 'add', 'view', 'edit', 'delete', 'pdf', 'excel', 'datatable', 'search'], 'allow' => '*']
            ],
            Controller\PredioController::class => [
                ['actions' => ['index', 'add', 'view', 'edit', 'pdf', 'excel', 'searchCatastral', 'autofillCatastral'], 'allow' => '*']
            ],
            Controller\BibliotecaController::class => [
                ['actions' => ['index', 'add', 'view', 'deleteFile', 'downloadFile'], 'allow' => '*']
            ],
            Controller\BibliotecaCategoriaController::class => [
                ['actions' => ['index', 'add', 'view', 'edit', 'delete'], 'allow' => '*']
            ],
            Controller\AportacionController::class => [
                ['actions' => ['index', 'validation', 'datatable', 'searchRfc', 'autofillRfc', 'searchCatastral', 'autofillCatastral', 'add', 'pdf', 'excel',], 'allow' => '*']
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            Service\PruebaManager::class => Service\Factory\PruebaFactory::class,
            Service\ContribuyenteManager::class => Service\Factory\ContribuyenteFactory::class,
            Service\PredioManager::class => Service\Factory\PredioFactory::class,
            Service\AportacionManager::class => Service\Factory\AportacionFactory::class,
            Service\BibliotecaManager::class => Service\Factory\BibliotecaFactory::class,
            Service\BibliotecaCategoriaManager::class => Service\Factory\BibliotecaCategoriaFactory::class,
            Service\AportacionControllerManager::class => Service\Factory\AportacionFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
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
                __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];

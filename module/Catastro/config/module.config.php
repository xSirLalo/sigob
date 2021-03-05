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
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action[/:id]]',
                    'defaults' => [
                        'controller'    => Controller\HomeController::class,
                        'action'        => 'index',
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\HomeController::class => Controller\Factory\HomeControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
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
                'paths' => [__DIR__ . '/../src/'],
            ],
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                __NAMESPACE__ . '\Model\Entity' => __NAMESPACE__ . '_driver',
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                //'Model\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];

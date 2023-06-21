<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'inventory' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/inventory',
                    'defaults' => [
                        'controller' => Controller\InventoryController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'inventory-detail' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/inventory/:id',
                    'defaults' => [
                        'controller' => Controller\InventoryController::class,
                        'action'     => 'show',
                    ],
                    'constraints' => [
                        'id' => '\d+',
                    ],
                ],
            ],
            'resep' => [
                'type'    => 'segment',
                'options' => [
                    'route'       => '/resep[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults'    => [
                        'controller' => Controller\ResepController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\InventoryController::class => InvokableFactory::class,
            Controller\ResepController::class => function($container) {
                $resepTable = $container->get(Model\ResepTable::class);
                return new Controller\ResepController($resepTable);
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            Model\ResepTable::class => function ($container) {
                $dbAdapter = $container->get(AdapterInterface::class);
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Model\Resep());
                return new Model\ResepTable('reseps', $dbAdapter, null, $resultSetPrototype);
            },
        ],
    ],
];

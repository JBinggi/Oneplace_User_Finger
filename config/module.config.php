<?php
/**
 * module.config.php - Finger Config
 *
 * Main Config File for Finger Finger Plugin
 *
 * @category Config
 * @package User\Finger
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace JBinggi\User\Finger;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Finger Module - Routes
    'router' => [
        'routes' => [
            'user-finger' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/user/finger[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\FingerController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'user-finger-setup' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/user/finger/setup[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'checkdb',
                    ],
                ],
            ],
        ],
    ], # Routes

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'user-finger' => __DIR__ . '/../view',
        ],
    ],
];
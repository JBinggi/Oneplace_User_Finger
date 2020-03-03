<?php
/**
 * Module.php - Module Class
 *
 * Module Class File for User-Finger Plugin
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

use Application\Controller\CoreEntityController;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\EventManager\EventInterface as Event;
use Laminas\ModuleManager\ModuleManager;
use JBinggi\User\Finger\Controller\FingerController;
use JBinggi\User\Finger\Model\FingerTable;

class Module {
    /**
     * Module Version
     *
     * @since 1.0.0
     */
    const VERSION = '1.0.0';

    /**
     * Load module config file
     *
     * @since 1.0.0
     * @return array
     */
    public function getConfig() : array {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(Event $e)
    {
        // This method is called once the MVC bootstrapping is complete
        $application = $e->getApplication();
        $container    = $application->getServiceManager();
        $oDbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = $container->get(FingerTable::class);

        # Register Filter Plugin Hook
    }

    /**
     * Load Models
     */
    public function getServiceConfig() : array {
        return [
            'factories' => [
                # Finger Plugin - Base Model
                Model\FingerTable::class => function($container) {
                    $tableGateway = $container->get(Model\FingerTableGateway::class);
                    return new Model\FingerTable($tableGateway,$container);
                },
                Model\FingerTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Finger($dbAdapter));
                    return new TableGateway('user_finger', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    } # getServiceConfig()

    /**
     * Load Controllers
     */
    public function getControllerConfig() : array {
        return [
            'factories' => [
                # Plugin Example Controller
                Controller\FingerController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    $tableGateway = $container->get(FingerTable::class);

                    # hook start
                    # hook end
                    return new Controller\FingerController(
                        $oDbAdapter,
                        $tableGateway,
                        $container
                    );
                },
                # Installer
                Controller\InstallController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\InstallController(
                        $oDbAdapter,
                        $container->get(Model\AddressTable::class),
                        $container
                    );
                },
            ],
        ];
    } # getControllerConfig()
}

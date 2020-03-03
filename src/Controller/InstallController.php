<?php
/**
 * InstallController.php - Main Controller
 *
 * Installer for Plugin
 *
 * @category Controller
 * @package User\Finger
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace JBinggi\User\Finger\Controller;

use Application\Controller\CoreUpdateController;
use Application\Model\CoreEntityModel;
use JBinggi\User\Finger\Model\FingerTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;

class InstallController extends CoreUpdateController {
    /**
     * InstallController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param FingerTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter, FingerTable $oTableGateway, $oServiceManager)
    {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'userfinger-single';
        parent::__construct($oDbAdapter, $oTableGateway, $oServiceManager);

        if ($oTableGateway) {
            # Attach TableGateway to Entity Models
            if (! isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    public function checkdbAction()
    {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('user');

        $oRequest = $this->getRequest();

        if(! $oRequest->isPost()) {

            $bTableExists = false;

            try {
                $this->oTableGateway->fetchAll(false);
                $bTableExists = true;
            } catch (\RuntimeException $e) {

            }

            return new ViewModel([
                'bTableExists' => $bTableExists,
                'sVendor' => 'jbinggi',
                'sModule' => 'jbinggi-user-finger',
            ]);
        } else {
            $sSetupConfig = $oRequest->getPost('plc_module_setup_config');

            $sSetupFile = 'vendor/jbinggi/jbinggi-user-finger/data/install.sql';
            if(file_exists($sSetupFile)) {
                echo 'got install file..';
                $this->parseSQLInstallFile($sSetupFile,CoreUpdateController::$oDbAdapter);
            }

            if($sSetupConfig != '') {
                $sConfigStruct = 'vendor/jbinggi/jbinggi-user-finger/data/structure_'.$sSetupConfig.'.sql';
                if(file_exists($sConfigStruct)) {
                    echo 'got struct file for config '.$sSetupConfig;
                    $this->parseSQLInstallFile($sConfigStruct,CoreUpdateController::$oDbAdapter);
                }
                $sConfigData = 'vendor/jbinggi/jbinggi-user-finger/data/data_'.$sSetupConfig.'.sql';
                if(file_exists($sConfigData)) {
                    echo 'got data file for config '.$sSetupConfig;
                    $this->parseSQLInstallFile($sConfigData,CoreUpdateController::$oDbAdapter);
                }
            }

            $oModTbl = new TableGateway('core_module', CoreUpdateController::$oDbAdapter);
            $oModTbl->insert([
                'module_key' => 'jbinggi-user-finger',
                'type' => 'plugin',
                'version' => \JBinggi\User\Finger\Module::VERSION,
                'label' => 'onePlace User Finger',
                'vendor' => 'jbinggi',
            ]);

            try {
                $this->oTableGateway->fetchAll(false);
                $bTableExists = true;
            } catch (\RuntimeException $e) {

            }
            $bTableExists = false;

            $this->flashMessenger()->addSuccessMessage('User Finger DB Update successful');
            $this->redirect()->toRoute('application', ['action' => 'checkforupdates']);
        }
    }
}

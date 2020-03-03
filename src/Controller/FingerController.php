<?php
/**
 * FingerController.php - Main Controller
 *
 * Main Controller for Finger Finger Plugin
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

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use JBinggi\User\Finger\Model\FingerTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class FingerController extends CoreEntityController {
    /**
     * Finger Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    /**
     * FingerController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param FingerTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,FingerTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'userfinger-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    # Custom Code here:

}

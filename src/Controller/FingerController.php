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

    /**
     * User Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {
        # You can just use the default function and customize it via hooks
        # or replace the entire function if you need more customization
        return $this->generateIndexView('userfinger');
    }

    public function addAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * article-add-before (before show add form)
         * article-add-before-save (before save)
         * article-add-after-save (after save)
         */
        $iArticleID = $this->params()->fromRoute('id', 0);

        return $this->generateAddView('userfinger','userfinger-single','user','view',$iArticleID,['iFingerID'=>$iArticleID]);
    }

    public function attachFingerToUser($oItem,$aRawData) {
        $oItem->user_idfs = $aRawData['ref_idfs'];
        return $oItem;
    }

    public function attachFingerToUserAPI($oItem) {
        var_dump($oItem);
        try {
            $oFingerTbl = CoreEntityController::$oServiceManager->get(FingerTable::class);
        } catch(\RuntimeException $e) {
            return [];
        }
        $oFingers = $oFingerTbl->fetchAll(false, ['user_idfs' => $oItem->getID()]);
        $aResult = ['fingers' => []];
        if (count($oFingers) > 0) {
            foreach ($oFingers as $oVar) {
                $aResult['fingers'][] = (object)[
                    'id' => $oVar->getID(),
                    'label' => $oVar->getLabel(),
                    'finger_id' => $oVar->finger_id,
                ];
            }
        }

        return $aResult;
    }

    # Custom Code here:
    public function attachFingerForm($oItem = false) {
        $oForm = CoreEntityController::$aCoreTables['core-form']->select(['form_key'=>'userfinger-single']);
        $aFields = [
            'finger-base' => CoreEntityController::$aCoreTables['core-form-field']->select(['form' => 'userfinger-single']),
        ];
        # Try to get Finger table
        try {
            $oFingerTbl = CoreEntityController::$oServiceManager->get(FingerTable::class);
        } catch(\RuntimeException $e) {
            //echo '<div class="alert alert-danger"><b>Error:</b> Could not load address table</div>';
            return [];
        }

        if(!isset($oFingerTbl)) {
            return [];
        }

        $aFinger = [];
        if($oItem) {
            # load contact addresses
            $oFinger = $oFingerTbl->fetchAll(false, ['user_idfs' => $oItem->getID()]);

            # get primary address
            if (count($oFinger) > 0) {
                foreach ($oFinger as $oFinger) {
                    $aFinger[] = $oFinger;
                }
            }
        }
        var_dump(count($aFinger));


        # Pass Data to View - which will pass it to our partial
        return [
            # must be named aPartialExtraData
            'aPartialExtraData' => [
                # must be name of your partial
                'user_finger'=> [
                    'oFinger'=>$aFinger,
                    'oForm'=>$oForm,
                    'aFormFields'=>$aFields,
                ]
            ]
        ];
    }
}

<?php
/**
 * Finger.php - Finger Entity
 *
 * Entity Model for Finger Finger
 *
 * @category Model
 * @package User\Finger
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace JBinggi\User\Finger\Model;

use Application\Model\CoreEntityModel;

class Finger extends CoreEntityModel {
    /**
     * Finger constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @since 1.0.0
     */
    public function __construct($oDbAdapter) {
        parent::__construct($oDbAdapter);

        # Set Single Form Name
        $this->sSingleForm = 'userfinger-single';

        # Attach Dynamic Fields to Entity Model
        $this->attachDynamicFields();
    }

    /**
     * Set Entity Data based on Data given
     *
     * @param array $aData
     * @since 1.0.0
     */
    public function exchangeArray(array $aData) {
        $this->id = !empty($aData['Finger_ID']) ? $aData['Finger_ID'] : 0;

        $this->updateDynamicFields($aData);
    }

    public function getLabel() {
        return $this->street;
    }
}
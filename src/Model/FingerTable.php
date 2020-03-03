<?php
/**
 * FingerTable.php - Finger Table
 *
 * Table Model for Finger Finger
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

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class FingerTable extends CoreEntityTable {

    /**
     * FingerTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'userfinger-single';
    }

    /**
     * Get Finger Entity
     *
     * @param int $id
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        # Use core function
        return $this->getSingleEntity($id,'Finger_ID');
    }

    /**
     * Save Finger Entity
     *
     * @param Finger $oFinger
     * @return int Finger ID
     * @since 1.0.0
     */
    public function saveSingle(Finger $oFinger) {
        $aData = [];

        $aData = $this->attachDynamicFields($aData,$oFinger);

        $id = (int) $oFinger->id;

        if ($id === 0) {
            # Add Metadata
            $aData['created_by'] = CoreController::$oSession->oUser->getID();
            $aData['created_date'] = date('Y-m-d H:i:s',time());
            $aData['modified_by'] = CoreController::$oSession->oUser->getID();
            $aData['modified_date'] = date('Y-m-d H:i:s',time());

            # Insert Finger
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Finger Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update Finger with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = CoreController::$oSession->oUser->getID();
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Finger
        $this->oTableGateway->update($aData, ['Finger_ID' => $id]);

        return $id;
    }

    /**
     * Generate new single Entity
     *
     * @return Finger
     * @since 1.0.0
     */
    public function generateNew() {
        return new Finger($this->oTableGateway->getAdapter());
    }
}
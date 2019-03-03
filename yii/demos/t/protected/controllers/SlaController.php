<?php
class SlaController extends Controller {
 
    public function actions() {
        return array(
            'getRowForm' => array(
                'class' => 'ext.dynamictabularform.actions.GetRowForm',
                'view' => '_rowForm',
                'modelClass' => 'SlaDetail'
            ),
        );
    }
 
    /**
     * without relation extension
     */
    public function actionCreate() {
        /**
         * a typical setup... SLA is my header and its details is the SlaDetail model
         * this i like a regular receipt
         */
        $sla = new Sla();
        $sladetails = array(new SlaDetail);
 
        if (isset($_POST['Sla'])) {
            $sla->attributes = $_POST['Sla'];
 
            /**
             * creating an array of sladetail objects
             */
            if (isset($_POST['SlaDetail'])) {
                $sladetails = array();
                foreach ($_POST['SlaDetail'] as $key => $value) {
                    /*
                     * sladetail needs a scenario wherein the fk sla_id
                     * is not required because the ID can only be
                     * linked after the sla has been saved
                     */
                    $sladetail = new SlaDetail('batchSave');
                    $sladetail->attributes = $value;
                    $sladetails[] = $sladetail;
                }
            }
            /**
             * validating the sla and array of sladetail
             */
            $valid = $sla->validate();
            foreach ($sladetails as $sladetail) {
                $valid = $sladetail->validate() & $valid;
            }
 
            if ($valid) {
                $transaction = $sla->getDbConnection()->beginTransaction();
                try {
                    $sla->save();
                    $sla->refresh();
 
                    foreach ($sladetails as $sladetail) {
                        $sladetail->sla_id = $sla->id;
                        $sladetail->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
 
 
 
                $this->redirect(array('view', 'id' => $sla->id));
            }
        }
        $this->render('create', array(
            'sla' => $sla,
            'sladetails' => $sladetails
        ));
    }
 
    public function actionUpdate($id) {
        $sla = $this->loadModel($id);
        $sladetails = $sla->slaDetails;
 
        if (isset($_POST['Sla'])) {
            $sla->attributes = $_POST['Sla'];
 
            if (isset($_POST['SlaDetail'])) {
                $sladetails = array();
                foreach ($_POST['SlaDetail'] as $key => $value) {
                    /**
                     * here we will take advantage of the updateType attribute so
                     * that we will be able to determine what we want to do 
                     * to a specific row
                     */
 
                    if ($value['updateType'] == DynamicTabularForm::UPDATE_TYPE_CREATE)
                        $sladetails[$key] = new SlaDetail();
 
                    else if ($value['updateType'] == DynamicTabularForm::UPDATE_TYPE_UPDATE)
                        $sladetails[$key] = SlaDetail::model()->findByPk($value['id']);
 
                    else if ($value['updateType'] == DynamicTabularForm::UPDATE_TYPE_DELETE) {
                        $delete = SlaDetail::model()->findByPk($value['id']);
                        if ($delete->delete()) {
                            unset($sladetails[$key]);
                            continue;
                        }
                    }
                    $sladetails[$key]->attributes = $value;
                }
            }
 
            $valid = $sla->validate();
            foreach ($sladetails as $sladetail) {
                $valid = $sladetail->validate() & $valid;
            }
 
            if ($valid) {
                $transaction = $sla->getDbConnection()->beginTransaction();
                try {
                    $sla->save();
                    $sla->refresh();
 
                    foreach ($sladetails as $sladetail) {
                        $sladetail->sla_id = $sla->id;
                        $sladetail->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
 
 
 
                $this->redirect(array('view', 'id' => $sla->id));
            }
        }
 
        $this->render('create', array(
            'sla' => $sla,
            'sladetails' => $sladetails
        ));
    }
 
}
?>
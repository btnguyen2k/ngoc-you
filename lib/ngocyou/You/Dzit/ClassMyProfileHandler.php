<?php
require_once 'dao/dbUtils.php';
class You_Dzit_MyProfileHandler extends You_Dzit_RequireLoggedInHandler {

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }
}
?>

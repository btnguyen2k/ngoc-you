<?php
class You_Dzit_ErrorHandler extends You_Dzit_BaseActionHandler {

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        $errorMsg = $this->getApplication()->getAttribute(You_Dzit_Constants::APP_ATTR_ERROR_MESSAGE);
        $this->populateModelPageErrorMessage($errorMsg);
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }
}
?>

<?php
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

class You_Dzit_RegisterDoneHandler extends You_Dzit_BaseActionHandler {
    
    private $user = NULL;
    
    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $id = isset($_GET['id']) ? $_GET['id']+0 : 0;
        $this->user = getUser($id);
        
        $this->populateDataModels();
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }
    
    protected function populateModelPageContent() {
        $lang = $this->getLanguage();
        $msg = $lang->getMessage('register.done', $this->user!==NULL ? Array($this->user->getLoginName()) : NULL);
        $this->populateModelPageInformationMessage($msg);
    }
}
?>

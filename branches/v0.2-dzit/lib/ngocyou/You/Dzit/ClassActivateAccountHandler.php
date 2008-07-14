<?php
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

class You_Dzit_ActivateAccountHandler extends You_Dzit_BaseActionHandler {
    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        
        $id = isset($_GET['id']) ? $_GET['id']+0 : 0;
        $activationCode = isset($_GET['activationCode']) ? trim($_GET['activationCode']) : NULL;
        $user = getUser($id);

        $lang = $this->getLanguage();
        if ( $user === NULL ) {
            $this->populateModelPageErrorMessage($lang->getMessage('error.userNotFound'));
        } elseif ( !$user->isActivated() && $user->getActivationCode()!==$activationCode ) {
            $this->populateModelPageErrorMessage($lang->getMessage('error.activationCodeNotMatch'));
        } else {
            if ( !$user->isActivated() ) {
                $user->setActivationCode(NULL);
                updateUser($user);
            }
            $msg = $lang->getMessage('activateAccount.done', Array($user->getLoginName()));
            $this->populateModelPageInformationMessage($msg);
        }
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }
}
?>

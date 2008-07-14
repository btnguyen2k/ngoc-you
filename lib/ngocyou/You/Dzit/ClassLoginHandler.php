<?php
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

class You_Dzit_LoginHandler extends You_Dzit_BaseActionHandler {

    const FORM_FIELD_LOGIN_NAME = 'loginName';
    const FORM_FIELD_PASSWORD   = 'password';

    protected function saveCurrentUrl() {
        return false;
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        $form = $this->populateForm();
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $lang = $this->getLanguage();
            $loginName = $form->getField(self::FORM_FIELD_LOGIN_NAME);
            $pwd = $form->getField(self::FORM_FIELD_PASSWORD);
            $user = getUserByLoginName($loginName);
            if ( $user === NULL ) {
                $form->addErrorMessage($lang->getMessage('error.userNotFound'));
            }
            if ( $user !== NULL && !$user->authenticate($pwd) ) {
                $form->addErrorMessage($lang->getMessage('error.passwordNotMatch'));
            }
            if ( !$form->hasErrorMessage() ) {
                $_SESSION[You_Dzit_Constants::SESSION_CURRENT_USER_ID] = $user->getId();
                $sessionName = You_Dzit_Constants::SESSION_LAST_ACCESS_PAGE;
                $url = isset($_SESSION[$sessionName]) ? $_SESSION[$sessionName] : NULL;
                if ( $url === NULL ) {
                    $app = $this->getApplication();
                    $urlCreator = $app->getUrlCreator();
                    $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX);
                }
                return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
            }
        }
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }

    protected function populateForm() {
        $formModel = $this->getRootDataModel(You_Dzit_Constants::DATA_MODEL_FORM);
        if ( $formModel === NULL ) {
            $form = new You_DataModel_Form('frmLogin');
            $formModel = new Ddth_Template_DataModel_Bean(You_Dzit_Constants::DATA_MODEL_FORM, $form);
            $this->populateRootDataModel(You_Dzit_Constants::DATA_MODEL_FORM, $formModel);
        }
        $form = $formModel->getValue();
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_LOGIN));
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX));
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_LOGIN_NAME;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, strtolower($value));

            $field = self::FORM_FIELD_PASSWORD;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        }
        return $form;
    }
}
?>

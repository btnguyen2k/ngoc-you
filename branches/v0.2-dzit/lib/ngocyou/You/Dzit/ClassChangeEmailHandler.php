<?php
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

class You_Dzit_ChangeEmailHandler extends You_Dzit_RequireLoggedInHandler {

    const FORM_FIELD_PASSWORD            = 'password';
    const FORM_FIELD_NEW_EMAIL           = 'newEmail';
    const FORM_FIELD_CONFIRMED_NEW_EMAIL = 'confirmedNewEmail';

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        $form = $this->populateForm();
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $app = $this->getApplication();
            $lang = $this->getLanguage();
            $user = $app->getCurrentUser();
            $pwd = $form->getField(self::FORM_FIELD_PASSWORD);
            $newEmail = $form->getField(self::FORM_FIELD_NEW_EMAIL);
            $confirmedEmail = $form->getField(self::FORM_FIELD_CONFIRMED_NEW_EMAIL);
            if ( $user === NULL ) {
                //should never happen!!!
                $form->addErrorMessage($lang->getMessage('error.userNotFound'));
            }
            if ( $user !== NULL && !$user->authenticate($pwd) ) {
                $form->addErrorMessage($lang->getMessage('error.passwordNotMatch'));
            }
            if ( $newEmail === "" ) {
                $form->addErrorMessage($lang->getMessage('error.emptyEmail'));
            }
            if ( $newEmail !== $confirmedEmail ) {
                $form->addErrorMessage($lang->getMessage('error.confirmedEmailNotMatch'));
            }
            if ( !$form->hasErrorMessage() ) {
                $oldEmail = trim($user->getEmail());
                if ( strtolower($oldEmail) !== strtolower($newEmail) ) {
                    if ( getUserByEmail($newEmail) !== NULL ) {
                        $form->addErrorMessage($lang->getMessage('error.emailAlreadyExists'));
                    }
                }
                if ( !$form->hasErrorMessage() ) {
                    $user->setEmail($newEmail);
                    updateUser($user);
                    $msg = $lang->getMessage('member.changeEmail.done');
                    $this->populateModelPageInformationMessage($msg);
                    return new Ddth_Dzit_ControlForward_ActionControlForward(You_Dzit_Constants::ACTION_MEMBER_MYPROFILE);
                }
            }
        }
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }

    protected function populateForm() {
        $formModel = $this->getRootDataModel(You_Dzit_Constants::DATA_MODEL_FORM);
        if ( $formModel === NULL ) {
            $form = new You_DataModel_Form('frmChangeEmail');
            $formModel = new Ddth_Template_DataModel_Bean(You_Dzit_Constants::DATA_MODEL_FORM, $form);
            $this->populateRootDataModel(You_Dzit_Constants::DATA_MODEL_FORM, $formModel);
        }
        $form = $formModel->getValue();
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_CHANGE_EMAIL));
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MYPROFILE));
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_PASSWORD;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_NEW_EMAIL;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_CONFIRMED_NEW_EMAIL;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        } else {
            $user = $app->getCurrentUser();
            $field = self::FORM_FIELD_NEW_EMAIL;
            $form->setField($field, $user->getEmail());

            $field = self::FORM_FIELD_CONFIRMED_NEW_EMAIL;
            $form->setField($field, $user->getEmail());
        }
        return $form;
    }
}
?>

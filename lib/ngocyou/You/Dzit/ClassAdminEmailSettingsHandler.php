<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminEmailSettingsHandler extends You_Dzit_AdminHandler {

    const FORM_FIELD_EMAIL_OUTGOING      = 'emailOutgoing';
    const FORM_FIELD_EMAIL_ADMINISTRATOR = 'emailAdministrator';

    private $form;

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $form = $this->form;
            $app = $this->getApplication();
            $lang = $this->getLanguage();
            $emailOutgoing = $form->getField(self::FORM_FIELD_EMAIL_OUTGOING);
            $emailAdministrator = $form->getField(self::FORM_FIELD_EMAIL_ADMINISTRATOR);

            //TODO: sanity checking?
            
            if ( !$form->hasErrorMessage() ) {
                updateConfig(You_Dzit_Constants::CONFIG_EMAIL_ADMINISTRATOR, $emailAdministrator);
                updateConfig(You_Dzit_Constants::CONFIG_EMAIL_OUTGOING, $emailOutgoing);
                $msg = $lang->getMessage('admin.emailSettings.done');
                $transmission = $app->createTransmission($msg);                
                $urlParams = Array(Ddth_Dzit_DzitConstants::URL_PARAM_TRANSMISSION => $transmission->getId());
                $urlCreator = $app->getUrlCreator();
                $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CP, Array(), $urlParams);
                return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
            }
        }
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageForm()}
     */
    protected function populateModelPageForm($page) {
        $name = Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_FORM;
        $node = $page->getChild($name);
        $form = NULL;
        if ( $node === NULL ) {
            $form = new You_DataModel_Form('frmEmailSettings');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($_SERVER['REQUEST_URI']);
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CP));
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_EMAIL_ADMINISTRATOR;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_EMAIL_OUTGOING;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        } else {
            $field = self::FORM_FIELD_EMAIL_ADMINISTRATOR;
            $value = getConfig(You_Dzit_Constants::CONFIG_EMAIL_ADMINISTRATOR);
            $form->setField($field, $value);

            $field = self::FORM_FIELD_EMAIL_OUTGOING;
            $value = getConfig(You_Dzit_Constants::CONFIG_EMAIL_OUTGOING);
            $form->setField($field, $value);
        }
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageContent()}
     */
    protected function populateModelPageContent($page) {
        $name = Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_CONTENT;
        $node = $page->getChild($name);
        if ( $node === NULL ) {
            $node = new Ddth_Template_DataModel_Map($name);
            $page->addChild($name, $node);
        }
    }
}
?>

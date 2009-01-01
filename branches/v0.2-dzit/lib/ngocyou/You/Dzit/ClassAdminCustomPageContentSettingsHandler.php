<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminCustomPageContentSettingsHandler extends You_Dzit_AdminHandler {

    const FORM_FIELD_LEFT   = 'left';
    const FORM_FIELD_RIGHT  = 'right';
    const FORM_FIELD_TOP    = 'top';
    const FORM_FIELD_BOTTOM = 'bottom';

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
            $contentLeft = $form->getField(self::FORM_FIELD_LEFT);
            $contentRight = $form->getField(self::FORM_FIELD_RIGHT);
            $contentTop = $form->getField(self::FORM_FIELD_TOP);
            $contentBottom = $form->getField(self::FORM_FIELD_BOTTOM);
            
            //TODO: sanity checking?            
            

            if ( !$form->hasErrorMessage() ) {
                updateConfig(You_Dzit_Constants::CONFIG_CUSTOM_PAGE_CONTENT_BOTTOM, $contentBottom);
                updateConfig(You_Dzit_Constants::CONFIG_CUSTOM_PAGE_CONTENT_LEFT, $contentLeft);
                updateConfig(You_Dzit_Constants::CONFIG_CUSTOM_PAGE_CONTENT_RIGHT, $contentRight);
                updateConfig(You_Dzit_Constants::CONFIG_CUSTOM_PAGE_CONTENT_TOP, $contentTop);
                $msg = $lang->getMessage('admin.customPageContentSettings.done');
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
            $form = new You_DataModel_Form('frmCustomPageContentSettings');
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
            $field = self::FORM_FIELD_BOTTOM;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_LEFT;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_RIGHT;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_TOP;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        } else {
            $field = self::FORM_FIELD_BOTTOM;
            $value = getConfig(You_Dzit_Constants::CONFIG_CUSTOM_PAGE_CONTENT_BOTTOM);
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_LEFT;
            $value = getConfig(You_Dzit_Constants::CONFIG_CUSTOM_PAGE_CONTENT_LEFT);
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_RIGHT;
            $value = getConfig(You_Dzit_Constants::CONFIG_CUSTOM_PAGE_CONTENT_RIGHT);
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_TOP;
            $value = getConfig(You_Dzit_Constants::CONFIG_CUSTOM_PAGE_CONTENT_TOP);
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

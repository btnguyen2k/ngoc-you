<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminSiteSettingsHandler extends You_Dzit_AdminHandler {

    const FORM_FIELD_SITE_NAME     = 'siteName';
    const FORM_FIELD_SITE_TITLE    = 'siteTitle';
    const FORM_FIELD_SITE_DESC     = 'siteDescription';
    const FORM_FIELD_SITE_KEYWORDS = 'siteKeywords';

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
            $siteDesc = $form->getField(self::FORM_FIELD_SITE_DESC);
            $siteKeywords = $form->getField(self::FORM_FIELD_SITE_KEYWORDS);
            $siteName = $form->getField(self::FORM_FIELD_SITE_NAME);
            $siteTitle = $form->getField(self::FORM_FIELD_SITE_TITLE);

            //TODO: sanity checking?
            
            if ( !$form->hasErrorMessage() ) {
                updateConfig(You_Dzit_Constants::CONFIG_SITE_NAME, $siteName);
                updateConfig(You_Dzit_Constants::CONFIG_SITE_TITLE, $siteTitle);
                updateConfig(You_Dzit_Constants::CONFIG_SITE_DESCRIPTION, $siteDesc);
                updateConfig(You_Dzit_Constants::CONFIG_SITE_KEYWORDS, $siteKeywords);
                $msg = $lang->getMessage('admin.siteSettings.done');
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
            $form = new You_DataModel_Form('frmSiteSettings');
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
            $field = self::FORM_FIELD_SITE_DESC;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_SITE_KEYWORDS;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_SITE_NAME;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_SITE_TITLE;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        } else {
            $field = self::FORM_FIELD_SITE_DESC;
            $value = getConfig(You_Dzit_Constants::CONFIG_SITE_DESCRIPTION);
            $form->setField($field, $value);

            $field = self::FORM_FIELD_SITE_KEYWORDS;
            $value = getConfig(You_Dzit_Constants::CONFIG_SITE_KEYWORDS);
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_SITE_NAME;
            $value = getConfig(You_Dzit_Constants::CONFIG_SITE_NAME);
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_SITE_TITLE;
            $value = getConfig(You_Dzit_Constants::CONFIG_SITE_TITLE);
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

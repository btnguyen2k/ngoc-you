<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminAdsSettingsHandler extends You_Dzit_AdminHandler {

    const FORM_FIELD_ADS_EXPIRY_DAYS         = 'adsExpiryDays';
    const FORM_FIELD_AUTO_DELETE_EXPIRED_ADS = 'autoDeleteExpiredAds';

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
            $adsExpiryDays = $form->getField(self::FORM_FIELD_ADS_EXPIRY_DAYS)+0;
            $autoDeleteExpiredAds = $form->getField(self::FORM_FIELD_AUTO_DELETE_EXPIRED_ADS) > 0;
            if ( $adsExpiryDays < 1 ) {
                $adsExpiryDays = 1;
            }
            
            if ( !$form->hasErrorMessage() ) {
                updateConfig(You_Dzit_Constants::CONFIG_ADS_EXPIRY_DAYS, $adsExpiryDays);
                updateConfig(You_Dzit_Constants::CONFIG_AUTO_DELETE_EXPIRED_ADS, $autoDeleteExpiredAds ? 1 : 0);
                updateEntryExpiry($adsExpiryDays);
                $msg = $lang->getMessage('admin.adsSettings.done');
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
            $form = new You_DataModel_Form('frmAdsSettings');
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
            $field = self::FORM_FIELD_ADS_EXPIRY_DAYS;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_AUTO_DELETE_EXPIRED_ADS;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);
        } else {
            $field = self::FORM_FIELD_ADS_EXPIRY_DAYS;
            $value = getConfig(You_Dzit_Constants::CONFIG_ADS_EXPIRY_DAYS);
            $form->setField($field, $value);
            
            $field = self::FORM_FIELD_AUTO_DELETE_EXPIRED_ADS;
            $value = getConfig(You_Dzit_Constants::CONFIG_AUTO_DELETE_EXPIRED_ADS);
            $form->setField($field, $value);
        }
    }
}
?>

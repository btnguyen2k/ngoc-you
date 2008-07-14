<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminCpHandler extends You_Dzit_AdminHandler {

    const DATAMODEL_NUMBER_USER_ACCOUNTS = 'numberUserAccounts';
    const DATAMODEL_NUMBER_CATEGORIES    = 'numberCategories';
    const DATAMODEL_NUMBER_ADS           = 'numberAds';
    const DATAMODEL_NUMBER_EXPIRED_ADS   = 'numberExpiredAds';
    const DATAMODEL_NUMBER_REPORTED_ADS  = 'numberReportedAds';
    
    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
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
        $node->addChild(self::DATAMODEL_NUMBER_USER_ACCOUNTS, countUsers());
        $node->addChild(self::DATAMODEL_NUMBER_CATEGORIES, countCategories());
        $node->addChild(self::DATAMODEL_NUMBER_ADS, countEntries());
        $node->addChild(self::DATAMODEL_NUMBER_EXPIRED_ADS, countExpiredEntries());
        $node->addChild(self::DATAMODEL_NUMBER_REPORTED_ADS, countReportedEntries());
    }
}
?>

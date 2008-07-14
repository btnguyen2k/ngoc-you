<?php
require_once 'dao/dbUtils.php';
class You_Dzit_MyAdsHandler extends You_Dzit_RequireLoggedInHandler {

    const DATAMODEL_ADS_LIST = 'adsList';     
    
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
        $user = $this->getApplication()->getCurrentUser();
        $adsForUser = getEntriesForUser($user->getId());
        $model = Array();
        foreach ( $adsForUser as $entry ) {
            $model[] = new You_DataModel_Entry($entry);
        }
        $node->addChild(self::DATAMODEL_ADS_LIST, $model);
    }
}
?>

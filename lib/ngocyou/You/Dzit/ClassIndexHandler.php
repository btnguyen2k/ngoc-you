<?php
require_once 'dao/dbUtils.php';
class You_Dzit_IndexHandler extends You_Dzit_BaseActionHandler {

    const DATAMODEL_CATEGORY_TREE = 'categoryTree';

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        if ( (rand(0, 10) > 7)
                && (getConfig(You_Dzit_Constants::CONFIG_AUTO_DELETE_EXPIRED_ADS) > 0) ) {
            deleteExpiredEntries();
        }
        
        $this->populateDataModels();
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }

    /**
     * {@see You_Dzit_BaseActionHandler::getUrlRss()}
     */
    protected function getUrlRss() {
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_RSS);
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
        $catTree = getCategoryTree();
        $model = Array();
        foreach ( $catTree as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $model);
    }
}
?>

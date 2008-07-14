<?php
require_once 'dao/dbUtils.php';
class You_Dzit_IndexHandler extends You_Dzit_BaseActionHandler {

    const DATAMODEL_CATEGORY_TREE = 'categoryTree';

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
        $catTree = getCategoryTree();
        $model = Array();
        foreach ( $catTree as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $model);
    }
}
?>

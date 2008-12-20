<?php
require_once 'dao/dbUtils.php';
class You_Dzit_ViewCatHandler extends You_Dzit_BaseActionHandler {

    const DATAMODEL_CATEGORY        = 'category';
    const DATAMODEL_CATEGORY_TREE   = 'categoryTree';
    const DATAMODEL_SUBCAT_LIST     = 'subCatList';
    const DATAMODEL_ADS_LIST        = 'adsList';
    const DATAMODEL_NUM_PAGES       = 'numPages';
    const DATAMODEL_PAGE_NUM        = 'pageNum';
    const DATAMODEL_PAGINATION      = 'pagination';

    const ENTRIES_PER_PAGE          = 20;

    private $form;
    private $cat;

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $id = isset($_GET['id']) ? $_GET['id']+0 : 0;
        $this->cat = getCategory($id);
        $app = $this->getApplication();
        $lang = $this->getLanguage();
        if ( $this->cat === NULL ) {
            $msg = $lang->getMessage('error.categoryNotFound');
            $app->setAttribute(You_Dzit_Constants::APP_ATTR_ERROR_MESSAGE, $msg);
            return new Ddth_Dzit_ControlForward_ActionControlForward(You_Dzit_Constants::ACTION_ERROR);
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
        $params = Array('cat'=>$this->cat->getId());
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_RSS, Array(), $params);
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

        //current category
        $node->addChild(self::DATAMODEL_CATEGORY, new You_DataModel_Category($this->cat));

        //category tree
        $catTree = getCategoryTree();
        $model = Array();
        foreach ( $catTree as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $model);

        //sub-categories
        $subCat = Array();
        if ( $this->cat->getNumChildren() > 0 ) {
            $subCat = $this->cat->getChildren();
        } else {
            $parent = getCategory($this->cat->getParentId());
            if ( $parent !== NULL ) {
                $subCat = $parent->getChildren();
            }
        }
        $model = Array();
        foreach ( $subCat as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_SUBCAT_LIST, $model);

        //current page
        $pageNum = isset($_GET['page']) ? $_GET['page']+0 : 1;
        if ( $pageNum < 1 ) {
            $pageNum = 1;
        }
        $node->addChild(self::DATAMODEL_PAGE_NUM, $pageNum);

        //entries
        $entries = getEntriesForCategory($this->cat->getId(), $pageNum, self::ENTRIES_PER_PAGE);
        $model = Array();
        foreach ( $entries as $entry ) {
            $model[] = new You_DataModel_Ads($entry);
        }
        $node->addChild(self::DATAMODEL_ADS_LIST, $model);

        //paging
        $numEntries = countEntriesForCategory($this->cat->getId());
        $numPages = $numEntries / self::ENTRIES_PER_PAGE;
        if ( $numPages * self::ENTRIES_PER_PAGE < $numEntries ) {
            $numPages++;
        }
        $pagination = new Ddth_Template_DataModel_List(self::DATAMODEL_PAGINATION);
        $app = $this->getApplication();
        $lang = $app->getLanguage();
        $urlCreator = $app->getUrlCreator();
        for ( $i = 1; $i <= $numPages; $i++ ) {
            
        }
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageHeaderTitle()}
     */
    protected function populateModelPageHeaderTitle($pageHeader) {
        $app = $this->getApplication();
        $title = $this->cat->getName() . ' - ' . getConfig(You_Dzit_Constants::CONFIG_SITE_NAME);
        $pageHeader->addChild(Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_HEADER_TITLE, $title);
    }
}
?>

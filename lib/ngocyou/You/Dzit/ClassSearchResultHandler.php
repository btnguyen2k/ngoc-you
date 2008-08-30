<?php
require_once 'dao/dbUtils.php';
class You_Dzit_SearchResultHandler extends You_Dzit_BaseActionHandler {

    const DATAMODEL_CATEGORY_TREE = 'categoryTree';
    const DATAMODEL_LOCATION_LIST = 'locationList';
    const DATAMODEL_NAVIGATOR     = 'navigator';
    const DATAMODEL_SEARCH_RESULT = 'searchResult';

    const ENTRIES_PER_PAGE = 20;

    private $searchResult;
    private $searchId;
    private $page;

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->id = isset($_GET['id']) ? $_GET['id'] + 0 : 0;
        $this->page = isset($_GET['p']) ? $_GET['p'] + 0 : 0;
        if ( $this->page < 1 ) {
            $this->page = 1;
        }
        $this->searchResult = getSearchResult($this->id, $this->page, self::ENTRIES_PER_PAGE);
        if ( $this->searchResult === NULL ) {
            echo NULL;
            return;
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
        $app = $this->getApplication();
        $lang = $app->getLanguage();
        $urlCreator = $app->getUrlCreator();
        $name = Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_CONTENT;
        $node = $page->getChild($name);
        if ( $node === NULL ) {
            $node = new Ddth_Template_DataModel_Map($name);
            $page->addChild($name, $node);
        }

        /* Category Tree */
        $catTree = getCategoryTree();
        $model = Array();
        foreach ( $catTree as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $model);

        /* Location List */
        $locationNode = new Ddth_Template_DataModel_List(self::DATAMODEL_LOCATION_LIST);
        $locations = getAllLocations();
        foreach ( $locations as $k=>$v ) {
            $locationNode->addChild(new Ddth_Template_DataModel_Map('', Array('key'=>$k, 'value'=>$v)));
        }
        $node->addChild(self::DATAMODEL_LOCATION_LIST, $locationNode);

        /* navigator */
        $model = Array();
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('home'), $urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX));
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('search'));
        $node->addChild(self::DATAMODEL_NAVIGATOR, $model);

        /* search result */
        $model = new You_DataModel_SearchResult($this->searchResult);
        $node->addChild(self::DATAMODEL_SEARCH_RESULT, $model);
    }
}
?>

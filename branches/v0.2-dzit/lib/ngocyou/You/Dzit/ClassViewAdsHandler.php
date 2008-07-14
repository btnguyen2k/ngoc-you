<?php
require_once 'dao/dbUtils.php';
class You_Dzit_ViewAdsHandler extends You_Dzit_BaseActionHandler {

    const DATAMODEL_ADS             = 'ads';
    const DATAMODEL_NAVIGATOR       = 'navigator';
    const DATAMODEL_CATEGORY_TREE   = 'categoryTree';
    
    /*
    const DATAMODEL_CATEGORY        = 'category';
    
    const DATAMODEL_SUBCAT_LIST     = 'subCatList';
    const DATAMODEL_ADS_LIST        = 'adsList';
    const DATAMODEL_NUM_PAGES       = 'numPages';
    const DATAMODEL_PAGE_NUM        = 'pageNum';

    const ENTRIES_PER_PAGE          = 20;
    
    private $form;
	*/
    private $ads;

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $id = isset($_GET['id']) ? $_GET['id']+0 : 0;
        $this->ads = getEntry($id);
        $app = $this->getApplication();
        $lang = $this->getLanguage();
        if ( $this->ads === NULL ) {
            $msg = $lang->getMessage('error.adsNotFound');
            $app->setAttribute(You_Dzit_Constants::APP_ATTR_ERROR_MESSAGE, $msg);
            return new Ddth_Dzit_ControlForward_ActionControlForward(You_Dzit_Constants::ACTION_ERROR);
        }
        increaseEntryNumViews($this->ads);
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
        $app = $this->getApplication();
        $lang = $app->getLanguage();
        $urlCreator = $app->getUrlCreator();
        
        /* ads */
        $node->addChild(self::DATAMODEL_ADS, new You_DataModel_Entry($this->ads));
        
        /* category tree */
        $catTree = getCategoryTree();
        $model = Array();
        foreach ( $catTree as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $model);

        /* navigator */
        $model = Array();
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('home'), $urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX));
        $dmCat = new You_DataModel_Category($this->ads->getCategory());
        $model[] = new You_DataModel_NavigatorEntry($dmCat->getName(), $dmCat->getUrlView());
        $model[] = new You_DataModel_NavigatorEntry($this->ads->getTitle());
        $node->addChild(self::DATAMODEL_NAVIGATOR, $model);
        
        /*
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
        
        $pageNum = isset($_GET['page']) ? $_GET['page']+0 : 1;
        if ( $pageNum < 1 ) {
            $pageNum = 1;
        }
        $node->addChild(self::DATAMODEL_PAGE_NUM, $pageNum);
        
        $entries = getEntriesForCategory($this->cat->getId(), $pageNum, self::ENTRIES_PER_PAGE);
        $model = Array();
        foreach ( $entries as $entry ) {
            $model[] = new You_DataModel_Entry($entry);
        }
        $node->addChild(self::DATAMODEL_ADS_LIST, $model);
		*/
    }
    
    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageHeaderTitle()}
     */
    protected function populateModelPageHeaderTitle($pageHeader) {
        $app = $this->getApplication();
        $title = $this->ads->getTitle() . ' - ' . $app->getYouProperty('you.site.name');
        $pageHeader->addChild(Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_HEADER_TITLE, $title);
    }
}
?>

<?php
require_once 'dao/dbUtils.php';
require_once 'dao/ClassSearchQuery.php';
class You_Dzit_SearchHandler extends You_Dzit_BaseActionHandler {

    const DATAMODEL_CATEGORY_TREE = 'categoryTree';
    const DATAMODEL_LOCATION_LIST = 'locationList';
    const DATAMODEL_NAVIGATOR     = 'navigator';

    const FORM_FIELD_QUERY    = 'q';
    const FORM_FIELD_LOCATION = 'l';
    const FORM_FIELD_CATEGORY = 'c';

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

            $cat = getCategory($form->getField(self::FORM_FIELD_CATEGORY));
            $location = $form->getField(self::FORM_FIELD_LOCATION);
            $query = $form->getField(self::FORM_FIELD_QUERY);
            $keywords = tokenizeSearchQuery($query);
            if ( count($keywords) < 1 ) {
                $form->addErrorMessage($lang->getMessage('error.emptySearchQuery'));
            } else {
                $searchQuery = new SearchQuery($query);
                if ( $cat !== NULL ) {
                    $searchQuery->addCategory($cat);
                }
                if ( $location > 0 ) {
                    $searchQuery->addLocation($location);
                }

                $searchResultId = searchEntries($searchQuery);
                if ( $searchResultId > 0 ) {
                    $urlCreator = $app->getUrlCreator();
                    $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_SEARCH_RESULT, Array(), Array('id'=>$searchResultId));
                    return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
                } else {
                    $form->addErrorMessage($lang->getMessage('searchNoResult'));
                }
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
            $form = new You_DataModel_Form('frmSearch');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_SEARCH));
        //$form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX));

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_CATEGORY;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);

            $field = self::FORM_FIELD_LOCATION;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);

            $field = self::FORM_FIELD_QUERY;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        } else {
        }
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
    }
}
?>

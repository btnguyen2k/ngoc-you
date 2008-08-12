<?php
require_once 'dao/dbUtils.php';

class You_Dzit_AdminReviewReportedAdsHandler extends You_Dzit_AdminHandler {

    const DATAMODEL_ADS             = 'ads';
    const DATAMODEL_NAVIGATOR       = 'navigator';
    const DATAMODEL_CATEGORY_TREE   = 'categoryTree';

    private $form = NULL;
    private $ads  = NULL;

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
        $this->populateDataModels();
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
            $form = new You_DataModel_Form('frmReviewAds');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_VIEW_REPORTED_ADS));
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
        $node->addChild(self::DATAMODEL_ADS, new You_DataModel_ReportedAds(getReportedEntry($this->ads->getId())));

        /* category tree */
        $catTree = getCategoryTree();
        $model = Array();
        foreach ( $catTree as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $model);
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageHeaderTitle()}
     */
    protected function populateModelPageHeaderTitle($pageHeader) {
        $app = $this->getApplication();
        $lang = $app->getLanguage();
        $title = $lang->getMessage('review') . ': ';
        $title .= $this->ads->getTitle() . ' - ' . getConfig(You_Dzit_Constants::CONFIG_SITE_NAME);
        $pageHeader->addChild(Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_HEADER_TITLE, $title);
    }
}
?>

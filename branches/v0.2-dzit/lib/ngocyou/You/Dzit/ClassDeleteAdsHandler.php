<?php
require_once 'dao/dbUtils.php';
class You_Dzit_DeleteAdsHandler extends You_Dzit_RequireLoggedInHandler {

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
        $user = $app->getCurrentUser();
        if ( $this->ads->getUserId() !== $user->getId() ) {
            $msg = $lang->getMessage('error.noPermission');
            $app->setAttribute(You_Dzit_Constants::APP_ATTR_ERROR_MESSAGE, $msg);
            return new Ddth_Dzit_ControlForward_ActionControlForward(You_Dzit_Constants::ACTION_ERROR);
        }
        $this->populateDataModels();
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $form = $this->form;
            if ( !$form->hasErrorMessage() ) {
                deleteEntry($this->ads->getId());
                $msg = $lang->getMessage('ads.delete.done');
                $transmission = $app->createTransmission($msg);
                $urlCreator = $app->getUrlCreator();
                $urlParams = Array(Ddth_Dzit_DzitConstants::URL_PARAM_TRANSMISSION=>$transmission->getId());
                $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MY_ADS, Array(), $urlParams);
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
            $form = new You_DataModel_Form('frmDeleteAds');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_DELETE_ADS, Array(), Array('id'=>$this->ads->getId())));
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MY_ADS));
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
        $node->addChild(self::DATAMODEL_ADS, new You_DataModel_Ads($this->ads));

        /* category tree */
        $catTree = getCategoryTree();
        $model = Array();
        foreach ( $catTree as $cat ) {
            $model[] = new You_DataModel_Category($cat);
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $model);

        /* navigator */
        $model = Array();
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('myprofile'), $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MYPROFILE));
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('member.myAds'), $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MY_ADS));
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('ads.delete'));
        $node->addChild(self::DATAMODEL_NAVIGATOR, $model);
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageHeaderTitle()}
     */
    protected function populateModelPageHeaderTitle($pageHeader) {
        $app = $this->getApplication();
        $lang = $app->getLanguage();
        $title = $lang->getMessage('ads.delete') . ': ';
        $title .= $this->ads->getTitle() . ' - ' . getConfig(You_Dzit_Constants::CONFIG_SITE_NAME);
        $pageHeader->addChild(Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_HEADER_TITLE, $title);
    }
}
?>

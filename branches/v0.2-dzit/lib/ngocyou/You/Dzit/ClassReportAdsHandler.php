<?php
require_once 'dao/dbUtils.php';
require_once 'includes/captcha.php';
class You_Dzit_ReportAdsHandler extends You_Dzit_BaseActionHandler {

    const DATAMODEL_ADS             = 'ads';
    const DATAMODEL_NAVIGATOR       = 'navigator';
    const DATAMODEL_CATEGORY_TREE   = 'categoryTree';

    const CAPTCHA_KEY               = 'CAPTCHA_REPORT_ADS';
    const FORM_FIELD_CAPTCHA        = 'captcha';

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
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $form = $this->form;
            $captcha = $form->getField(self::FORM_FIELD_CAPTCHA);
            if ( $captcha !== captchaGetCode(self::CAPTCHA_KEY) ) {
                $form->addErrorMessage($lang->getMessage('error.captchaCodeNotMatch'));
            }
            if ( !$form->hasErrorMessage() ) {
                reportEntry($this->ads, $app->getCurrentUser());
                captchaDelete(self::CAPTCHA_KEY);
                $msg = $lang->getMessage('ads.report.done');
                $transmission = $app->createTransmission($msg);
                $urlCreator = $app->getUrlCreator();
                $urlParams = Array('id'=>$this->ads->getId(), Ddth_Dzit_DzitConstants::URL_PARAM_TRANSMISSION=>$transmission->getId());
                $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_VIEW_ADS, Array(), $urlParams);
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
            $form = new You_DataModel_Form('frmPostAds');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_REPORT_ADS, Array(), Array('id'=>$this->ads->getId())));
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_VIEW_ADS, Array(), Array('id'=>$this->ads->getId())));
        $form->setCaptchaUrl($urlCreator->createUrl(You_Dzit_Constants::ACTION_CAPTCHA, Array(), Array('key'=>self::CAPTCHA_KEY)));

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_CAPTCHA;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        } else {
            captchaCreate(self::CAPTCHA_KEY);
        }
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
        $dmAds = new You_DataModel_Entry($this->ads);
        $model[] = new You_DataModel_NavigatorEntry($this->ads->getTitle(), $dmAds->getUrlView());
        $model[] = new You_DataModel_NavigatorEntry($lang->getMessage('ads.report'));
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
        $lang = $app->getLanguage();
        $title = $lang->getMessage('ads.report') . ': ';
        $title .= $this->ads->getTitle() . ' - ' . $app->getYouProperty('you.site.name');
        $pageHeader->addChild(Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_HEADER_TITLE, $title);
    }
}
?>

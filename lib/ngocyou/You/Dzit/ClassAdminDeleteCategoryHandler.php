<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminDeleteCategoryHandler extends You_Dzit_AdminHandler {

    const DATAMODEL_CATEGORY = 'category';

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
        } else if ( $this->cat->getNumChildren() > 0 ) {
            $msg = $lang->getMessage('error.deleteCategoryHasChildren');
            $app->setAttribute(You_Dzit_Constants::APP_ATTR_ERROR_MESSAGE, $msg);
            return new Ddth_Dzit_ControlForward_ActionControlForward(You_Dzit_Constants::ACTION_ERROR);
        }
        $this->populateDataModels();
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            deleteCategory($id);
            $urlCreator = $app->getUrlCreator();
            $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CATEGORY_LIST);
            return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
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
            $form = new You_DataModel_Form('frmDeleteCategory');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($_SERVER['REQUEST_URI']);
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CATEGORY_LIST));
        $lang = $this->getLanguage();
        $form->addErrorMessage($lang->getMessage('admin.deleteCategory.confirmation'));
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
        $node->addChild(self::DATAMODEL_CATEGORY, new You_DataModel_Category($this->cat));
    }
}
?>

<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminCategorySettingsHandler extends You_Dzit_AdminHandler {

    const FORM_FIELD_NUM_TOP_CATEGORIES = 'numTopCategories';

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
            $numTopCategories = $form->getField(self::FORM_FIELD_NUM_TOP_CATEGORIES)+0;
            
            if ( $numTopCategories < 1 ) {
                $numTopCategories = 1;
            }
            //TODO: sanity checking?            
            
            if ( !$form->hasErrorMessage() ) {
                updateConfig(You_Dzit_Constants::CONFIG_CATEGORY_NUM_TOP, $numTopCategories);
                $msg = $lang->getMessage('admin.categorySettings.done');
                $transmission = $app->createTransmission($msg);                
                $urlParams = Array(Ddth_Dzit_DzitConstants::URL_PARAM_TRANSMISSION => $transmission->getId());
                $urlCreator = $app->getUrlCreator();
                $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CP, Array(), $urlParams);
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
            $form = new You_DataModel_Form('frmCategorySettings');
            $node = new Ddth_Template_DataModel_Bean($name, $form);
            $page->addChild($name, $node);
        } else {
            $form = $node->getValue();
        }
        $this->form = $form;
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($_SERVER['REQUEST_URI']);
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CP));
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_NUM_TOP_CATEGORIES;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);
        } else {
            $field = self::FORM_FIELD_NUM_TOP_CATEGORIES;
            $value = getConfig(You_Dzit_Constants::CONFIG_CATEGORY_NUM_TOP);
            $form->setField($field, $value);
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
    }
}
?>

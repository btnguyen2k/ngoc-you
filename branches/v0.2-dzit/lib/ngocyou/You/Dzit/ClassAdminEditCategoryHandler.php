<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminEditCategoryHandler extends You_Dzit_AdminHandler {

    const DATAMODEL_CATEGORY_TREE         = 'categoryTree';

    const FORM_FIELD_CATEGORY_PARENT_ID   = 'categoryParentId';
    const FORM_FIELD_CATEGORY_NAME        = 'categoryName';
    const FORM_FIELD_CATEGORY_DESCRIPTION = 'categoryDescription';

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
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $form = $this->form;
            $app = $this->getApplication();
            $lang = $this->getLanguage();
            $parentId = $form->getField(self::FORM_FIELD_CATEGORY_PARENT_ID)+0;
            $catName = $form->getField(self::FORM_FIELD_CATEGORY_NAME);
            $catDesc = $form->getField(self::FORM_FIELD_CATEGORY_DESCRIPTION);
            if ( $catName === "" ) {
                $form->addErrorMessage($lang->getMessage('error.emptyCategoryName'));
            }
            if ( !$form->hasErrorMessage() ) {
                $parent = getCategory($parentId);
                $this->cat->setName($catName);
                $this->cat->setDescription($catDesc);
                if ( $this->cat->getNumChildren() > 0 || $parent === NULL ) {
                    $this->cat->setParentId(0);
                } elseif ( $parentId !== $this->cat->getId() ) {
                    $this->cat->setParentId($parentId);
                }
                updateCategory($this->cat);
                $urlCreator = $app->getUrlCreator();
                $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CATEGORY_LIST);
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
            $form = new You_DataModel_Form('frmCreateCategory');
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
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_CATEGORY_PARENT_ID;
            $value = isset($_POST[$field]) ? $_POST[$field]+0 : 0;
            $form->setField($field, $value);

            $field = self::FORM_FIELD_CATEGORY_NAME;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_CATEGORY_DESCRIPTION;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        } else {
            $field = self::FORM_FIELD_CATEGORY_PARENT_ID;
            $value = $this->cat->getParentId();
            $form->setField($field, $value);

            $field = self::FORM_FIELD_CATEGORY_NAME;
            $value = $this->cat->getName();
            $form->setField($field, $value);

            $field = self::FORM_FIELD_CATEGORY_DESCRIPTION;
            $value = $this->cat->getDescription();
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
        $orgTree = getCategoryTree();
        $catTree = Array();
        if ( $this->cat->getNumChildren() === 0 ) {
            foreach ( $orgTree as $cat ) {
                if ( $cat->getId() !== $this->cat->getId() ) {
                    $catTree[] = $cat;
                }
            }
        }
        $node->addChild(self::DATAMODEL_CATEGORY_TREE, $catTree);
    }
}
?>

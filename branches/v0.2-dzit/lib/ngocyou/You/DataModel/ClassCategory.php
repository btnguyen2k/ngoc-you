<?php
include_once 'dao/ClassCategory.php';

class You_DataModel_Category {
    /**
     * @var Category
     */
    private $category = NULL;

    private $children = NULL;

    public function __construct($category) {
        $this->category = $category;
    }

    public function getId() {
        return $this->category->getId();
    }
    
    public function getParentId() {
        return $this->category->getParentId();
    }

    public function getName() {
        return $this->category->getName();
    }

    public function getNumChildren() {
        return $this->category->getNumChildren();
    }

    public function getChildren() {
        if ( $this->children === NULL ) {
            $this->children = Array();
            foreach ( $this->category->getChildren() as $child ) {
                $this->children[] = new You_DataModel_Category($child);
            }
        }
        return $this->children;
    }

    public function getNumEntries() {
        return $this->category->getNumEntries();
    }

    public function getNumEntriesIncChildren() {
        return $this->category->getNumEntriesIncChildren();
    }

    public function getUrlDelete() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_DELETE_CATEGORY, Array(), Array('id'=>$this->getId()));
    }

    public function getUrlEdit() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_EDIT_CATEGORY, Array(), Array('id'=>$this->getId()));
    }

    public function getUrlView() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_VIEW_CATEGORY, Array(), Array('id'=>$this->getId()));
    }
}
?>
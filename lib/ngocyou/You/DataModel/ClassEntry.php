<?php
include_once 'dao/ClassEntry.php';

class You_DataModel_Entry {
    /**
     * @var Entry
     */
    private $entry = NULL;
    
    public function __construct($entry) {
        $this->entry = $entry;
    }
    
    public function getId() {
        return $this->entry->getId();
    }
    
    public function getContent() {
        return $this->entry->getContent();
    }
    
    public function getContentForDisplay() {
        return $this->entry->getContentForDisplay();
    }
    
    public function getLocationStr() {
        $locations = getAllLocations();
        $loc = $this->entry->getLocation();
        return isset($locations[$loc]) ? $locations[$loc] : '';
    }
    
    public function getTitle() {
        return $this->entry->getTitle();
    }
    
    public function getNumViews() {
        return $this->entry->getNumViews();
    }
    
    public function getExpiryDate() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $dateFormat = $app->getYouProperty('you.format.datetime');
        return date($dateFormat, $this->entry->getExpiryTimestamp());
    }
    
    public function getPostDate() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $dateFormat = $app->getYouProperty('you.format.datetime');
        return date($dateFormat, $this->entry->getCreationTimestamp());
    }
    
    public function getPosterName() {
        return $this->entry->getPoster()->getLoginName();
    }
    
    public function getUrlContactPoster() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_CONTACT_POSTER, Array(), Array('id'=>$this->getId()));
    }
    
    public function getUrlDelete() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_DELETE_ADS, Array(), Array('id'=>$this->getId()));
    }
    
    public function getUrlEdit() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_EDIT_ADS, Array(), Array('id'=>$this->getId()));
    }
    
    public function getUrlReport() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_REPORT_ADS, Array(), Array('id'=>$this->getId()));
    }
    
    public function getUrlView() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_VIEW_ADS, Array(), Array('id'=>$this->getId()));
    }
    
    public function hasAttachment() {
        return $this->entry->countAttachments() > 0;
    }
}
?>
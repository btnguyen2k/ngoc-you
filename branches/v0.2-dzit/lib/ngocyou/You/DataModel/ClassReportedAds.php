<?php
include_once 'dao/ClassReportedEntry.php';
require_once 'dao/dbUtils.php';

class You_DataModel_ReportedAds {
    /**
     * @var ReportedEntry
     */
    private $reportedEntry = NULL;
    
    public function __construct($entry) {
        $this->reportedEntry = $entry;
    }
    
    public function getId() {
        return $this->reportedEntry->getId();
    }
    
    public function getContentForDisplay() {
        return $this->reportedEntry->getEntry()->getContentForDisplay();
    }
    
    public function getExpiryDate() {
        $dateFormat = getConfig(You_Dzit_Constants::CONFIG_DATETIME_FORMAT);
        return date($dateFormat, $this->reportedEntry->getEntry()->getExpiryTimestamp());
    }

    public function getLocationStr() {
        $locations = getAllLocations();
        $loc = $this->reportedEntry->getEntry()->getLocation();
        return isset($locations[$loc]) ? $locations[$loc] : '';
    }
    
    public function getPrice() {
        return $this->reportedEntry->getEntry()->getPrice();
    }
    
    public function getTitle() {
        return $this->reportedEntry->getEntry()->getTitle();
    }
    
    public function getPostDate() {
        $dateFormat = getConfig(You_Dzit_Constants::CONFIG_DATETIME_FORMAT);
        return date($dateFormat, $this->reportedEntry->getCreationTimestamp());
    }
    
    public function getPosterName() {
        return $this->reportedEntry->getEntry()->getPoster()->getLoginName();
    }
    
    public function getUrlView() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_VIEW_ADS, Array(), Array('id'=>$this->getId()));
    }
    
    public function getUrlDeleteReported() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_DELETE_REPORTED_ADS, Array(), Array('id'=>$this->getId()));
    }
    
    public function getUrlUnreport() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_UNREPORT_ADS, Array(), Array('id'=>$this->getId()));
    }
    
    public function getUrlReviewReported() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_REVIEW_REPORTED_ADS, Array(), Array('id'=>$this->getId()));
    }    
    
    
    
    public function hasAttachment() {
        return $this->reportedEntry->getEntry()->countAttachments() > 0;
    }
}
?>
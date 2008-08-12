<?php
include_once 'dao/ClassUpload.php';

class You_DataModel_Attachment {
    /**
     * @var Upload
     */
    private $attachment = NULL;
    
    public function __construct($attachment) {
        $this->attachment = $attachment;
    }
    
    public function getId() {
        return $this->attachment->getId();
    }

    public function getUrlThumbnail() {
        $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
        $urlCreator = $app->getUrlCreator();
        $urlParams = Array('id' => $this->getId(), 'ads' => $this->attachment->getEntryId());
        return $urlCreator->createUrl(You_Dzit_Constants::ACTION_ATTACHMENT_THUMBNAIL, Array(), $urlParams);
    }
}
?>
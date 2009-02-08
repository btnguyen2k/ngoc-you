<?php
require_once 'includes/utils.php';
class Entry {

    const TYPE_SELL = 0;
    const TYPE_BUY  = 1;

    private $id = 0;
    private $catId = 0;
    private $userId = 0;
    private $creationTimestamp = 0;
    private $expiryTimestamp = 0;
    private $title = NULL;
    private $content = NULL;
    private $numViews = 0;
    private $location = NULL;
    private $price = NULL;
    private $type = self::TYPE_SELL;
    private $poster = NULL;
    private $attachments = Array();
    private $isHtml = 0;
    private $category = NULL;

    public function __construct() {
    }

    public function isExpired() {
        return $this->expiryTimestamp < time();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value+0;
    }

    public function getCategoryId() {
        return $this->catId;
    }

    public function setCategoryId($value) {
        $this->catId = $value+0;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($value) {
        $this->category = $value;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($value) {
        $this->userId = $value+0;
    }

    public function getCreationTimestamp() {
        return $this->creationTimestamp;
    }

    public function setCreationTimestamp($value) {
        $this->creationTimestamp = $value+0;
    }

    public function getExpiryTimestamp() {
        return $this->expiryTimestamp;
    }

    public function setExpiryTimestamp($value) {
        $this->expiryTimestamp = $value+0;
    }

    public function getPoster() {
        return $this->poster;
    }

    public function setPoster($value) {
        $this->poster = $value;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($value) {
        $this->title = $value!==NULL ? trim($value) : NULL;
    }

    public function getContent() {
        return $this->content;
    }

    public function getContentForDisplay() {
        global $BASE_ALLOWED_TAGS;
        global $ADMIN_ALLOWED_TAGS;
        //TODO
        return $this->content;
        //return removeEvilHtmlTags($this->content);
    }

    public function setContent($value) {
        $this->content = $value!==NULL ? trim($value) : NULL;
    }

    public function getNumViews() {
        return $this->numViews;
    }

    public function setNumViews($value) {
        $this->numViews = $value+0;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($value) {
        $this->location = $value!==NULL ? $value+0 : NULL;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($value) {
        $this->price = $value!==NULL ? ($value+0) : NULL;
    }

    public function getType() {
        return ($this->type === self::TYPE_SELL) ? (self::TYPE_SELL) : (self::TYPE_BUY);
    }

    public function setType($value) {
        $this->type = $value!==NULL ? $value+0 : self::TYPE_SELL;
    }

    public function countAttachmentSize() {
        $result = 0;
        foreach ( $this->attachments as $upload ) {
            $result += $upload->getFileSize();
        }
        return $result;
    }

    public function countAttachments() {
        return count($this->attachments);
    }

    public function hasAttachment() {
        return count($this->attachments) > 0;
    }

    public function addAttachment($upload) {
        $this->attachments[$upload->getId()] = $upload;
    }

    public function deleteAttachment($id) {
        if ( isset($this->attachments[$id]) ) {
            unset($this->attachments[$id]);
        }
    }

    public function getAllAttachments() {
        return array_values($this->attachments);
    }

    public function getAttachment($id) {
        return isset($this->attachments[$id]) ? $this->attachments[$id] : NULL;
    }

    public function isHtml() {
        return $this->isHtml;
    }

    public function setIsHtml($value) {
        $this->isHtml = $value+0;
    }

    public function populate($tblRow) {
        $this->setId(isset($tblRow['eid'])?$tblRow['eid']:0);
        $this->setCategoryId(isset($tblRow['ecatid'])?$tblRow['ecatid']:0);
        $this->setUserId(isset($tblRow['euserid'])?$tblRow['euserid']:0);
        $this->setCreationTimestamp(isset($tblRow['ecreationtimestamp'])?$tblRow['ecreationtimestamp']:0);
        $this->setExpiryTimestamp(isset($tblRow['eexpirytimestamp'])?$tblRow['eexpirytimestamp']:0);
        $this->setTitle(isset($tblRow['etitle'])?$tblRow['etitle']:NULL);
        $this->setContent(isset($tblRow['ebody'])?$tblRow['ebody']:NULL);
        $this->setNumViews(isset($tblRow['enumviews'])?$tblRow['enumviews']:0);
        $this->setLocation(isset($tblRow['elocation'])?$tblRow['elocation']:NULL);
        $this->setPrice(isset($tblRow['eprice'])?$tblRow['eprice']:NULL);
        $this->setType(isset($tblRow['etype'])?$tblRow['etype']:self::TYPE_SELL);
        $this->setIsHtml(isset($tblRow['ehtml'])?$tblRow['ehtml']+0:0);
    }
}
?>
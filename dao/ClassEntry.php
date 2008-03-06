<?php
require_once 'includes/utils.php';
class Entry {
	private $id = 0;
	private $catId = 0;
	private $userId = 0;
	private $creationTimestamp = 0;
	private $expiryTimestamp = 0;
	private $title = NULL;
	private $content = NULL;
	private $numViews = 0;
	private $poster = NULL;
	
	public function __construct() {
		$this->id = 0;
		$this->catId = 0;
		$this->userId = 0;
		$this->creationTimestamp = 0;
		$this->expiryTimestamp = 0;
		$this->title  = NULL;
		$this->content  = NULL;
		$this->numViews = 0;
		$this->poster = NULL;
	}
	
	public function isExpired() {
		return $this->expiryTimestamp < time();
	}
	
	public function getId() {
		return $this->id+0;
	}
	
	public function setId($value) {
		$this->id = $value;
	}
	
	public function getCategoryId() {
		return $this->catId+0;
	}
	
	public function setCategoryId($value) {
		$this->catId = $value;
	}
	
	public function getUserId() {
		return $this->userId+0;
	}
	
	public function setUserId($value) {
		$this->userId = $value;
	}
	
	public function getCreationTimestamp() {
		return $this->creationTimestamp+0;
	}
	
	public function setCreationTimestamp($value) {
		$this->creationTimestamp = $value;
	}
	
	public function getExpiryTimestamp() {
		return $this->expiryTimestamp+0;
	}
	
	public function setExpiryTimestamp($value) {
		$this->expiryTimestamp = $value;
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
		$this->title = $value;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function getContentForDisplay() {
	    return removeEvilHtmlTags($this->content);
	}
	
	public function setContent($value) {
		$this->content = $value;
	}
	
	public function getNumViews() {
		return $this->numViews+0;
	}
	
	public function setNumViews($value) {
		$this->numViews = $value;
	}
	
	public function populate($tblRow) {
		$this->id = $tblRow['eid']+0;
		$this->catId = $tblRow['ecatid']+0;
		$this->userId = $tblRow['euserid']+0;
		$this->creationTimestamp = $tblRow['ecreationtimestamp']+0;
		$this->expiryTimestamp = $tblRow['eexpirytimestamp']+0;
		$this->title = $tblRow['etitle'];
		if ( $this->title != NULL ) $this->title = trim($this->title);
		$this->content = $tblRow['ebody'];
		if ( $this->content != NULL ) $this->content = trim($this->content);
		$this->numViews = $tblRow['enumviews']+0;
	}
}
?>
<?php
class Entry {
	var $id;
	var $catId;
	var $userId;
	var $creationTimestamp;
	var $expiryTimestamp;
	var $title;
	var $content;
	
	function Category() {
		$this->id = 0;
		$this->catId = 0;
		$this->userId = 0;
		$this->creationTimestamp = 0;
		$this->expiryTimestamp = 0;
		$this->title  = NULL;
		$this->content  = NULL;
	}
	
	function getId() {
		return $this->id+0;
	}
	
	function setId($value) {
		$this->id = $value;
	}
	
	function getCategoryId() {
		return $this->catId+0;
	}
	
	function setCategoryId($value) {
		$this->catId = $value;
	}
	
	function getUserId() {
		return $this->userId+0;
	}
	
	function setUserId($value) {
		$this->userId = $value;
	}
	
	function getCreationTimestamp() {
		return $this->creationTimestamp+0;
	}
	
	function setCreationTimestamp($value) {
		$this->creationTimestamp = $value;
	}
	
	function getExpiryTimestamp() {
		return $this->expiryTimestamp+0;
	}
	
	function setExpiryTimestamp($value) {
		$this->expiryTimestamp = $value;
	}
	
	function getTitle() {
		return $this->title;
	}
	
	function setTitle($value) {
		$this->title = $value;
	}
	
	function getContent() {
		return $this->content;
	}
	
	function setContent($value) {
		$this->content = $value;
	}
	
	function populate($tblRow) {
		$this->id = $tblRow['eid']+0;
		$this->catId = $tblRow['ecatid']+0;
		$this->userId = $tblRow['euserid']+0;
		$this->creationTimestamp = $tblRow['ecreationtimestamp']+0;
		$this->expiryTimestamp = $tblRow['eexpirytimestamp']+0;
		$this->title = $tblRow['etitle'];
		if ( $this->title != NULL ) $this->title = trim($this->title);
		$this->content = $tblRow['ebody'];
		if ( $this->content != NULL ) $this->content = trim($this->content);
	}
}
?>
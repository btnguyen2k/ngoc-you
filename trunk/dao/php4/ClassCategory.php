<?php
class Category {
	var $id;
	var $parentId;
	var $position;
	var $name;
	var $desc;
	
	function Category() {
		$this->id = 0;
		$this->parentId = NULL;
		$this->position = 0;
		$this->name = NULL;
		$this->desc = NULL;
	}
	
	function getId() {
		return $this->id;
	}
	
	function setId($value) {
		$this->id = $value;
	}
	
	function getParentId() {
		return $this->parentId;
	}
	
	function setParentId($value) {
		$this->parentId = $value;
	}
	
	function getPosition() {
		return $this->position;
	}
	
	function setPosition($value) {
		$this->position = $value;
	}
	
	function getName() {
		return $this->name;
	}
	
	function setName($value) {
		$this->name = $value;
	}
	
	function getDescription() {
		return $this->desc;
	}
	
	function setDescription($value) {
		$this->desc = $value;
	}
}
?>
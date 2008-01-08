<?php
class Group {
	var $id;
	var $name;
	var $desc;
	
	function Group() {
		$this->id = 0;
		$this->name = NULL;
		$this->desc = NULL;
	}
	
	function getId() {
		return $this->id;
	}
	
	function setId($value) {
		$this->id = $value;
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
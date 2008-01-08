<?php
class Category {
	var $id;
	var $parentId;
	var $position;
	var $name;
	var $desc;
	var $children;
	
	function Category() {
		$this->id = 0;
		$this->parentId = NULL;
		$this->position = 0;
		$this->name = NULL;
		$this->desc = NULL;
		$this->children = Array();
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
	
	function asChild($cat, $sortChildren=true) {
		//check if $cat is an instance of Category class
		if ( PHP_MAJOR_VERSION >= 5 ) {
			if ( !($cat instanceof Category) ) return NULL;
		} else {
			if ( !is_a($cat, "Category") ) return NULL;
		}
		
		if ( $cat->getParentId() != $this->getId() ) return NULL;
		
		if ( !is_array($this->children) ) {
			$this->children = Array();
		}

		$this->children[] = $cat;
		if ( $sortChildren ) { 
			usort($this->children, "__cmpChild");
		}

		return $cat;
	}
	
	function getChildren() {
		return $this->children;
	}
	
	function setChildren($value=Array()) {
		$this->children = Array();
		foreach ( $value as $cat ) {
			$this->addChild($cat, false);
		}
		usort($this->children, "__cmpChild");
	}
}

function __cmpChild($a, $b) {
	if ( $a->getPosition() == $b->getPosition() ) return 0;
	return $a->getPosition() < $b->getPosition() ? -1 : 1;
}
?>
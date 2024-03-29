<?php
class Category {
	var $id;
	var $parentId;
	var $position;
	var $name;
	var $desc;
	var $children;
	var $numViews;
	var $numEntries;

	function Category() {
		$this->id = 0;
		$this->parentId = NULL;
		$this->position = 0;
		$this->name = NULL;
		$this->desc = NULL;
		$this->children = Array();
		$this->numViews = 0;
		$this->numEntries = 0;
	}

	function getId() {
		return $this->id+0;
	}

	function setId($value) {
		$this->id = $value;
	}

	function getParentId() {
		return $this->parentId+0;
	}

	function setParentId($value) {
		$this->parentId = $value;
	}

	function getPosition() {
		return $this->position+0;
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

	function getNumEntries() {
		return $this->numEntries+0;
	}

	function setNumEntries($value) {
		$this->numEntries = $value;
	}

	function getNumViews() {
		return $this->numViews+0;
	}

	function setNumViews($value) {
		$this->numViews = $value;
	}

	function populate($tblRow) {
		$this->id = $tblRow['cid']+0;
		$this->parentId = $tblRow['cparentid']+0;
		$this->position = $tblRow['cposition']+0;
		$this->name = $tblRow['cname'];
		if ( $this->name !== NULL ) $this->name = trim($this->name);
		$this->desc = $tblRow['cdesc'];
		if ( $this->desc !== NULL ) $this->desc = trim($this->desc);
		$this->children = Array();
		$this->numViews = $tblRow['cnumviews']+0;
	}

	function addChild($cat, $sortChildren=true) {
		//check if $cat is an instance of Category class
		if ( PHP_MAJOR_VERSION >= 5 ) {
			if ( !($cat instanceof Category) ) return NULL;
		} else {
			if ( !is_a($cat, "Category") ) return NULL;
		}

		if ( $cat->getParentId() !== $this->getId() ) return NULL;

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

	function getNumChildren() {
		return count($this->children);
	}
}

//sort descendingly
function __cmpChild($a, $b) {
	if ( $a->getPosition() === $b->getPosition() ) return 0;
	return $a->getPosition() < $b->getPosition() ? 1 : -1;
}
?>
<?php
class Category {
	private $id = 0;
	private $parentId = NULL;
	private $position = 0;
	private $name = NULL;
	private $desc = NULL;
	private $children = Array();
	private $numViews = 0;
	private $numEntries = 0;

	public function __construct() {
	}

	public function getId() {
		return $this->id+0;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getParentId() {
		return $this->parentId+0;
	}

	public function setParentId($value) {
		$this->parentId = $value;
	}

	public function getPosition() {
		return $this->position+0;
	}

	public function setPosition($value) {
		$this->position = $value;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function getDescription() {
		return $this->desc;
	}

	public function setDescription($value) {
		$this->desc = $value;
	}

	public function getNumEntries() {
		return $this->numEntries+0;
	}

	public function setNumEntries($value) {
		$this->numEntries = $value;
	}

	public function getNumViews() {
		return $this->numViews+0;
	}

	public function setNumViews($value) {
		$this->numViews = $value;
	}

	public function populate($tblRow) {
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

	public function addChild($cat, $sortChildren=true) {
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

	public function getChildren() {
		return $this->children;
	}

	public function setChildren($value=Array()) {
		$this->children = Array();
		foreach ( $value as $cat ) {
			$this->addChild($cat, false);
		}
		usort($this->children, "__cmpChild");
	}

	public function getNumChildren() {
		return count($this->children);
	}
}

//sort descendingly
function __cmpChild($a, $b) {
	if ( $a->getPosition() === $b->getPosition() ) return 0;
	return $a->getPosition() < $b->getPosition() ? 1 : -1;
}
?>
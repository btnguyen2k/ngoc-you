<?php
class SearchQuery {
	private $query = '';
	private $catList = Array();
	private $locationList = Array();

	public function __construct($query) {
	    $this->setQuery($query);
	}

	public function getQuery() {
		return $this->query;
	}

	public function setQuery($value) {
		$this->query = trim($value);
	}

	public function addCategory($category) {
	    $this->catList[$category->getId()] = $category;
	}

	public function getCategoryList() {
	    return array_values($this->catList);
	}
	
	public function addLocation($locId) {
	    if ( $locId > 0 ) {
	        $this->locationList[$locId+0] = $locId+0;
	    }
	}
	
	public function getLocationList() {
	    return array_keys($this->locationList);
	}
}
?>
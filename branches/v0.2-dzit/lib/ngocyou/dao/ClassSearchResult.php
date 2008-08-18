<?php
class SearchResult {
	private $id;
    private $adsList = Array();
    public $currentPage = 1;
    public $pageLength = 1;

	public function __construct($id) {
	    $this->setId($id);
	}
	
	public function setId($id) {
	    $this->id = $id;
	}
	
    public function getId() {
        return $this->id;
	}
	
	public function getPage() {
	    return $this->currentPage;
	}
	
	public function setPage($page) {
	    $this->currentPage = $page+0;
	    if ( $this->currentPage < 1 ) {
	        $this->currentPage = 1;
	    }
	}

	public function addAds($ads) {
	    $this->adsList[] = $ads;
	}

	public function getAdsList() {
	    return $this->adsList;
	}
}
?>
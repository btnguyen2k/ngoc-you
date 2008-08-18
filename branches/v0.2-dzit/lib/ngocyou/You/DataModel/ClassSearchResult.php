<?php
include_once 'dao/ClassSearchResult.php';

class You_DataModel_SearchResult {
    /**
     * @var SearchResult
     */
    private $searchResult = NULL;
    
    public function __construct($searchResult) {
        $this->searchResult = $searchResult;
    }
    
    public function getAdsList() {
        $result = Array();
        foreach ( $this->searchResult->getAdsList() as $ads ) {
            $array[] = new You_DataModel_Ads($ads);
        }
        return $array;
    }
}
?>
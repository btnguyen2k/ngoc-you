<?php
class You_DataModel_NavigatorEntry {
    private $label = NULL;
    private $url   = NULL;

    public function __construct($label, $url=NULL) {
        $this->label = $label;
        $this->url = $url;
    }

    public function getLabel() {
        return $this->label;
    }
    
    public function getUrl() {
        return $this->url;
    }
    
    public function hasUrl() {
        return $this->url !== NULL && trim($this->url) !== '';
    }
}
?>
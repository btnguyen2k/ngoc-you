<?php
class You_Dzit_YouApplication extends Ddth_Dzit_App_GenericApplication {
    
    /**
     * You's application properties.
     *
     * @var Ddth_Commons_Properties
     */
    private $youProps = NULL;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function init($config) {
        parent::init($config);
        $this->initYouProperties();
    }
    
    protected function initYouProperties() {
        
    }
}
?>
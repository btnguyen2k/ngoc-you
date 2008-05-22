<?php
class You_Dzit_YouApplication extends Ddth_Dzit_App_GenericApplication {

    const YOU_CONFIG_FILE = 'you.properties';

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
        $fileContent = Ddth_Commons_Loader::loadFileContent(self::YOU_CONFIG_FILE);
        $this->youProps = new Ddth_Commons_Properties();
        $this->youProps->import($fileContent);
    }
    
    public function getYouProperty($key) {
        return $this->youProps->getProperty($key);
    }
}
?>
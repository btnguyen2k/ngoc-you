<?php
require_once 'dao/dbUtils.php';

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
    
    public function getCurrentUser() {
        $sessionName = You_Dzit_Constants::SESSION_CURRENT_USER_ID;
        return isset($_SESSION[$sessionName]) ? getUser($_SESSION[$sessionName]) : NULL;
    }
}
?>
<?php
require_once 'dao/dbUtils.php';

abstract class You_Dzit_BaseActionHandler extends Ddth_Dzit_ActionHandler_AbstractActionHandler {

    const DATAMODEL_CURRENT_USER        = 'currentUser';

    const DATAMODEL_URL_CREATOR         = 'urlCreator';

    const DATAMODEL_PAGE_CONTENT        = 'content';
    
    const DATAMODEL_PAGE_TRANSMISSION   = 'transmission';

    const DATAMODEL_ERROR_MESSAGE       = 'errorMessage';
    const DATAMODEL_INFORMATION_MESSAGE = 'informationMessage';


    const DATAMODEL_CONFIG              = 'config';
    const DATAMODEL_CONFIG_HOME_URI     = 'homeUri';
    const DATAMODEL_CONFIG_HOME_URL     = 'homeUrl';
    const DATAMODEL_CONFIG_TEMPLATE_URI = 'templateUri';
    const DATAMODEL_CONFIG_TEMPLATE_URL = 'templateUrl';

    const DATAMODEL_COMMON_URLS                 = 'commonUrls';
    const DATAMODEL_COMMON_URLS_HOME            = 'home';
    const DATAMODEL_COMMON_URLS_REGISTER        = 'register';
    const DATAMODEL_COMMON_URLS_LOGIN           = 'login';
    const DATAMODEL_COMMON_URLS_LOGOUT          = 'logout';
    const DATAMODEL_COMMON_URLS_FORGOT_PASSWORD = 'forgotPassword';
    const DATAMODEL_COMMON_URLS_MYPROFILE       = 'myprofile';
    const DATAMODEL_COMMON_URLS_ADMINCP         = 'adminCp';

    /**
     * {@see Ddth_Dzit_IActionHandler::execute()}
     */
    public function execute($action) {
        if ( $this->saveCurrentUrl() ) {
            $_SESSION[You_Dzit_Constants::SESSION_LAST_ACCESS_PAGE] = $_SERVER['REQUEST_URI'];
        }
        if ( $this->requiredLoggedIn() ) {
            $app = $this->getApplication();
            $user = $app->getCurrentUser();
            if ( $user === NULL ) {
                $urlCreator = $app->getUrlCreator();
                $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_LOGIN);
                return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
            }
        }
        return parent::execute($action);
    }

    /**
     * Indicates that the current access url should be saved for latter use.
     *
     * @return boolean
     */
    protected function saveCurrentUrl() {
        return true;
    }

    /**
     * Indicates that logged in user is required in order to perform this action.
     *
     * @return true
     */
    protected function requiredLoggedIn() {
        return false;
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateDataModels()}
     */
    protected function populateDataModels() {
        $this->populateCurrentUser();
        $this->populateUrlCreator();
        $this->populateModelConfig();
        $this->populateCommonUrls();
        parent::populateDataModels();
        $this->populatePageTransmission();
    }
    
    protected function populatePageTransmission() {
        $name = Ddth_Dzit_DzitConstants::DATAMODEL_PAGE;
        $modelPage = $this->getRootDataModel($name);
        if ( $modelPage !== NULL ) {
            $app = $this->getApplication();
            $transmission = $app->getTransmission();
            if ( $transmission !== NULL ) {
                $name = self::DATAMODEL_PAGE_TRANSMISSION;
                $node = new Ddth_Template_DataModel_Bean($name, $transmission);
                $modelPage->addChild($name, $node);
                $app->deleteTransmission($transmission->getId());
            }
        }
    }

    protected function populateCurrentUser() {
        $sessionName = You_Dzit_Constants::SESSION_CURRENT_USER_ID;
        $currentUser = isset($_SESSION[$sessionName]) ? getUser($_SESSION[$sessionName]) : NULL;
        if ( $currentUser !== NULL ) {
            $name = self::DATAMODEL_CURRENT_USER;
            $node = new Ddth_Template_DataModel_Bean($name, $currentUser);
            $this->populateRootDataModel($name, $node);
        }
    }

    protected function populateUrlCreator() {
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $name = self::DATAMODEL_URL_CREATOR;
        $node = $this->getRootDataModel($name);
        if ( $node === NULL ) {
            $node = new Ddth_Template_DataModel_Bean($name, $urlCreator);
            $this->populateRootDataModel($name, $node);
        }
    }

    protected function populateModelPageErrorMessage($msg) {
        $name = Ddth_Dzit_DzitConstants::DATAMODEL_PAGE;
        $modelPage = $this->getRootDataModel($name);
        if ( $modelPage !== NULL ) {
            $modelPageContent = $modelPage->getChild(self::DATAMODEL_PAGE_CONTENT);
            if ( $modelPageContent === NULL ) {
                $modelPageContent = new Ddth_Template_DataModel_Map(self::DATAMODEL_PAGE_CONTENT);
                $modelPage->addChild(self::DATAMODEL_PAGE_CONTENT, $modelPageContent);
            }
            $modelPageContent->addChild(self::DATAMODEL_ERROR_MESSAGE, $msg);
        }
    }

    protected function populateModelPageInformationMessage($msg) {
        $name = Ddth_Dzit_DzitConstants::DATAMODEL_PAGE;
        $modelPage = $this->getRootDataModel($name);
        if ( $modelPage !== NULL ) {
            $modelPageContent = $modelPage->getChild(self::DATAMODEL_PAGE_CONTENT);
            if ( $modelPageContent === NULL ) {
                $modelPageContent = new Ddth_Template_DataModel_Map(self::DATAMODEL_PAGE_CONTENT);
                $modelPage->addChild(self::DATAMODEL_PAGE_CONTENT, $modelPageContent);
            }
            $modelPageContent->addChild(self::DATAMODEL_INFORMATION_MESSAGE, $msg);
        }
    }

    //    /**
    //     * Gets template pack.
    //     *
    //     * @return Ddth_Template_ITemplate
    //     */
    //    protected function getTemplate() {
    //        return $this->getApplication()->getTemplate();
    //    }

    /**
     * Populates application's commons urls.
     *
     * @throws Ddth_Dzit_DzitException
     */
    protected function populateCommonUrls() {
        $name = self::DATAMODEL_COMMON_URLS;
        $node = $this->getRootDataModel($name);
        if ( $node === NULL ) {
            $node = new Ddth_Template_DataModel_Map($name);
            $this->populateRootDataModel($name, $node);
        }
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $node->addChild(self::DATAMODEL_COMMON_URLS_HOME, $urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX));
        $node->addChild(self::DATAMODEL_COMMON_URLS_REGISTER, $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_REGISTER));
        $node->addChild(self::DATAMODEL_COMMON_URLS_FORGOT_PASSWORD, $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_FORGOT_PASSWORD));
        $node->addChild(self::DATAMODEL_COMMON_URLS_LOGIN, $urlCreator->createUrl(You_Dzit_Constants::ACTION_LOGIN));
        $node->addChild(self::DATAMODEL_COMMON_URLS_LOGOUT, $urlCreator->createUrl(You_Dzit_Constants::ACTION_LOGOUT));
        $node->addChild(self::DATAMODEL_COMMON_URLS_MYPROFILE, $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MYPROFILE));
        $node->addChild(self::DATAMODEL_COMMON_URLS_ADMINCP, $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CP));
    }

    /**
     * Populates the application's configuration settings that template may need to access.
     *
     * @throws Ddth_Dzit_DzitException
     */
    protected function populateModelConfig() {
        $name = self::DATAMODEL_CONFIG;
        $node = $this->getRootDataModel($name);
        if ( $node === NULL ) {
            $node = new Ddth_Template_DataModel_Map($name);
            $this->populateRootDataModel($name, $node);
        }
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $homeUri = $urlCreator->getHomeUrl(false);
        $homeUrl = $urlCreator->getHomeUrl(true);
        $template = $app->getTemplate();
        $templateUri = $app->getYouProperty('you.templateUri');
        $templateUri = preg_replace('/\{folder\}/i', $template->getDir(), $templateUri);
        $templateUri = preg_replace('/\{name\}/i', $template->getName(), $templateUri);
        $templateUrl = preg_replace('/([^:])[\/]+/', '$1/', $homeUrl . '/' . $templateUri);
        $templateUri = preg_replace('/[\/]+/', '/', $homeUri . '/' . $templateUri);

        $node->addChild(self::DATAMODEL_CONFIG_HOME_URI, $homeUri);
        $node->addChild(self::DATAMODEL_CONFIG_HOME_URL, $homeUrl);
        $node->addChild(self::DATAMODEL_CONFIG_TEMPLATE_URI, $templateUri);
        $node->addChild(self::DATAMODEL_CONFIG_TEMPLATE_URL, $templateUrl);
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateModelPageHeaderTitle()}
     */
    protected function populateModelPageHeaderTitle($pageHeader) {
        $app = $this->getApplication();
        $title = $app->getYouProperty('you.site.name');
        $pageHeader->addChild(Ddth_Dzit_DzitConstants::DATAMODEL_PAGE_HEADER_TITLE, $title);
    }
}
?>

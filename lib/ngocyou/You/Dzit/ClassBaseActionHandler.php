<?php
abstract class You_Dzit_BaseActionHandler extends Ddth_Dzit_ActionHandler_AbstractActionHandler {

    const DATAMODEL_CONFIG              = 'config';

    const DATAMODEL_CONFIG_HOME_URI     = 'homeUri';

    const DATAMODEL_CONFIG_HOME_URL     = 'homeUrl';

    const DATAMODEL_CONFIG_TEMPLATE_URI = 'templateUri';

    const DATAMODEL_CONFIG_TEMPLATE_URL = 'templateUrl';

    
    const DATAMODEL_COMMON_URLS                 = 'commonUrls';
    
    const DATAMODEL_COMMON_URLS_REGISTER        = 'register';
    
    const DATAMODEL_COMMON_URLS_LOGIN           = 'login';
    
    const DATAMODEL_COMMON_URLS_LOGOUT          = 'logout';
    
    const DATAMODEL_COMMON_URLS_FORGOT_PASSWORD = 'forgotPassword';

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateDataModels()}
     */
    protected function populateDataModels() {
        $this->populateModelConfig();
        $this->populateCommonUrls();
        parent::populateDataModels();
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
        $node = new Ddth_Template_DataModel_Map($name);
        $this->populateRootDataModel($name, $node);

        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $node->addChild(self::DATAMODEL_COMMON_URLS_REGISTER, $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_REGISTER));
        $node->addChild(self::DATAMODEL_COMMON_URLS_FORGOT_PASSWORD, $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_FORGOT_PASSWORD));
        $node->addChild(self::DATAMODEL_COMMON_URLS_LOGIN, $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_LOGIN));
        $node->addChild(self::DATAMODEL_COMMON_URLS_LOGOUT, $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_LOGOUT));
    }

    /**
     * Populates the application's configuration settings that template may need to access.
     *
     * @throws Ddth_Dzit_DzitException
     */
    protected function populateModelConfig() {
        $name = self::DATAMODEL_CONFIG;
        $node = new Ddth_Template_DataModel_Map($name);
        $this->populateRootDataModel($name, $node);

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
}
?>

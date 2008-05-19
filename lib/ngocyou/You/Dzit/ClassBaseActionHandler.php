<?php
abstract class You_Dzit_BaseActionHandler extends Ddth_Dzit_ActionHandler_AbstractActionHandler {

    const DATAMODEL_CONFIG = 'config';

    const DATAMODEL_CONFIG_HOME_URI = 'homeUri';

    const DATAMODEL_CONFIG_HOME_URL = 'homeUrl';
    
    const DATAMODEL_CONFIG_TEMPLATE_URI = 'templateUri';

    const DATAMODEL_CONFIG_TEMPLATE_URL = 'templateUrl';

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::populateDataModels()}
     */
    protected function populateDataModels() {
        $this->populateModelConfig();
        parent::populateDataModels();
    }

    /**
     * Populates the application's configuration settings that template may need to access.
     *
     * @throws Ddth_Dzit_DzitException
     */
    protected function populateModelConfig() {
        $name = self::DATAMODEL_CONFIG;
        $node = new Ddth_Template_DataModel_Map($name);
        $this->populateRootDataModels($name, $node);

        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $node->addChild(self::DATAMODEL_CONFIG_HOME_URI, $urlCreator->getHomeUrl(false));
        $node->addChild(self::DATAMODEL_CONFIG_HOME_URL, $urlCreator->getHomeUrl(true));
    }
}
?>

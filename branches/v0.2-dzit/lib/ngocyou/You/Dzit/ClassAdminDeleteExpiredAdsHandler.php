<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminDeleteExpiredAdsHandler extends You_Dzit_AdminHandler {

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        deleteExpiredEntries();
        $app = $this->getApplication();
        $lang = $this->getLanguage();
        $msg = $lang->getMessage('admin.deleteExpiredAds.done');
        $transmission = $app->createTransmission($msg);
        $urlCreator = $app->getUrlCreator();
        $urlParams = Array(Ddth_Dzit_DzitConstants::URL_PARAM_TRANSMISSION=>$transmission->getId());
        $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CP, Array(), $urlParams);
        return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
    }
}
?>

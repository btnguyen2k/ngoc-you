<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminDeleteReportedAdsHandler extends You_Dzit_AdminHandler {

    private $ads  = NULL;

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $id = isset($_GET['id']) ? $_GET['id']+0 : 0;
        $this->ads = getEntry($id);
        $app = $this->getApplication();
        $lang = $this->getLanguage();
        if ( $this->ads === NULL ) {
            $msg = $lang->getMessage('error.adsNotFound');
            $app->setAttribute(You_Dzit_Constants::APP_ATTR_ERROR_MESSAGE, $msg);
            return new Ddth_Dzit_ControlForward_ActionControlForward(You_Dzit_Constants::ACTION_ERROR);
        }
		$urlCreator = $app->getUrlCreator();
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			deleteEntry($this->ads->getId());
			$msg = $lang->getMessage('ads.delete.done');
            $transmission = $app->createTransmission($msg);
			$urlParams = Array(Ddth_Dzit_DzitConstants::URL_PARAM_TRANSMISSION=>$transmission->getId());
			$url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_VIEW_REPORTED_ADS, Array(), $urlParams);
			return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
		} else {
			$urlParams = Array('id' => $this->ads->getId());
			$url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_REVIEW_REPORTED_ADS, Array(), $urlParams);
			return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
		}
    }
}
?>

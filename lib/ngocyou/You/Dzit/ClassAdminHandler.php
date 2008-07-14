<?php
abstract class You_Dzit_AdminHandler extends You_Dzit_RequireLoggedInHandler {
    /**
     * {@see Ddth_Dzit_IActionHandler::execute()}
     */
    public function execute($action) {
        $app = $this->getApplication();
        $user = $app->getCurrentUser();
        if ( $user === NULL || !$user->canAccessAdminCP() ) {
            $urlCreator = $app->getUrlCreator();
            $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_LOGIN);
            return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
        }
        return parent::execute($action);
    }
}
?>
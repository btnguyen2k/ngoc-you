<?php
class You_Dzit_LogoutHandler extends You_Dzit_BaseActionHandler {

    protected function saveCurrentUrl() {
        return false;
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        unset($_SESSION[You_Dzit_Constants::SESSION_CURRENT_USER_ID]);
        $sessionName = You_Dzit_Constants::SESSION_LAST_ACCESS_PAGE;
        $url = isset($_SESSION[$sessionName]) ? $_SESSION[$sessionName] : NULL;
        if ( $url === NULL ) {
            $app = $this->getApplication();
            $urlCreator = $app->getUrlCreator();
            $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX);
        }
        return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
    }
}
?>

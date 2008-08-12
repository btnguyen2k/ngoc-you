<?php
require_once 'includes/config.php';
require_once 'includes/captcha.php';

class You_Dzit_CaptchaHandler extends You_Dzit_BaseActionHandler {

	/**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::saveCurrentUrl()}
     */
    protected function saveCurrentUrl() {
        return false;
    }

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $key = isset($_GET['key']) ? $_GET['key'] : "";
        $image = captchaGetImage(96, 48, $key);
        header('Content-Type: image/jpeg');
        imageJpeg($image);
        imageDestroy($image);
        return NULL;
    }
}
?>

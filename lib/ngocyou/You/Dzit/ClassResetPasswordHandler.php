<?php
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

class You_Dzit_ResetPasswordHandler extends You_Dzit_BaseActionHandler {
    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();

        $id = isset($_GET['id']) ? $_GET['id']+0 : 0;
        $resetCode = isset($_GET['resetCode']) ? trim($_GET['resetCode']) : NULL;
        $user = getUser($id);
        $loggedResetCode = getResetPasswordCode($user);

        $lang = $this->getLanguage();
        if ( $user === NULL ) {
            $this->populateModelPageErrorMessage($lang->getMessage('error.userNotFound'));
        } elseif ( $loggedResetCode === NULL || $loggedResetCode !== $resetCode ) {
            $this->populateModelPageErrorMessage($lang->getMessage('error.resetPasswordCodeNotMatch'));
        } else {
            $app = $this->getApplication();
            $urlCreator = $app->getUrlCreator();
            
            removeResetPasswordRequest($user);
            $newPwd = substr(md5(rand(0, time())), 0, 4);
            $user->setPassword($user->encryptPassword($newPwd));
            updateUser($user);

            $subject = $lang->getMessage('email.resetPassword.subject');
            $subject = processEmailContent($subject);

            $body = $lang->getMessage('email.resetPassword.body');
            $body = processEmailContent($body);
            $urlMyProfile = $urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_MYPROFILE, Array(), Array(), "", true);
            $body = str_replace('{URL_MY_PROFILE}', $urlMyProfile, $body);
            $body = str_replace('{NEW_PASSWORD}', $newPwd, $body);
            
            sendEmail(getConfig(You_Dzit_Constants::CONFIG_EMAIL_OUTGOING), $user->getEmail(), $subject, $body, true);

            $msg = $lang->getMessage('resetPassword.done');
            $this->populateModelPageInformationMessage($msg);
        }
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }
}
?>

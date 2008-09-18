<?php
require_once 'includes/captcha.php';
require_once 'includes/utils.php';
require_once 'dao/dbUtils.php';

class You_Dzit_ForgotPasswordHandler extends You_Dzit_BaseActionHandler {

    const CAPTCHA_KEY                   = 'CAPTCHA_FORGOT_PASSWORD';
    const FORM_FIELD_LOGIN_NAME         = 'loginName';
    const FORM_FIELD_EMAIL              = 'email';
    const FORM_FIELD_CAPTCHA            = 'captcha';

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $this->populateDataModels();
        $form = $this->populateForm();
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
            captchaCreate(self::CAPTCHA_KEY);
        } else {
            $lang = $this->getLanguage();

            $loginName = $form->getField(self::FORM_FIELD_LOGIN_NAME);
            $email = $form->getField(self::FORM_FIELD_EMAIL);
            $captcha = $form->getField(self::FORM_FIELD_CAPTCHA);

            if ( $loginName === "" ) {
                $form->addErrorMessage($lang->getMessage('error.emptyLoginName'));
            }
            if ( $email === "" ) {
                $form->addErrorMessage($lang->getMessage('error.emptyEmail'));
            } else {
                $user = getUserByLoginName($loginName);
                if ( $user === NULL ) {
                    $form->addErrorMessage($lang->getMessage('error.userNotFound'));
                } elseif ( strtolower($user->getEmail()) !== strtolower($email) ) {
                    $form->addErrorMessage($lang->getMessage('error.emailNotMatch'));
                }
            }
            if ( $captcha !== captchaGetCode(self::CAPTCHA_KEY) ) {
                $form->addErrorMessage($lang->getMessage('error.captchaCodeNotMatch'));
            }
            if ( !$form->hasErrorMessage() ) {
                captchaDelete(self::CAPTCHA_KEY);
                
                $app = $this->getApplication();
                $urlCreator = $app->getUrlCreator();
                
                $resetCode = strtolower(md5(mt_rand(0, time())));
                logResetPasswordRequest($user, $resetCode);
                
                $subject = $lang->getMessage('email.forgotPassword.subject');
                $subject = processEmailContent($subject);
                
                $body = $lang->getMessage('email.forgotPassword.body');
                $body = processEmailContent($body);
                $urlResetPwd = $urlCreator->createUrl(
                    You_Dzit_Constants::ACTION_MEMBER_RESET_PASSWORD,
                    Array(),
                    Array('id' => $user->getId(), 'resetCode' => $resetCode),
                    "",
                    true
                );
                $body = str_replace('{URL_RESET_PASSWORD}', $urlResetPwd, $body);
                sendEmail(getConfig(You_Dzit_Constants::CONFIG_EMAIL_OUTGOING), $user->getEmail(), $subject, $body, true);
                
                $result = new Ddth_Dzit_ControlForward_UrlRedirectControlForward($urlCreator->createUrl(
                        You_Dzit_Constants::ACTION_MEMBER_FORGOT_PASSWORD_DONE,
                        Array(),
                        Array('id' => $user->getId())
                    )
                );
                return $result;
            }
        }
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }

    protected function populateForm() {
        $formModel = $this->getRootDataModel(You_Dzit_Constants::DATA_MODEL_FORM);
        if ( $formModel === NULL ) {
            $form = new You_DataModel_Form('frmForgotPassword');
            $formModel = new Ddth_Template_DataModel_Bean(You_Dzit_Constants::DATA_MODEL_FORM, $form);
            $this->populateRootDataModel(You_Dzit_Constants::DATA_MODEL_FORM, $formModel);
        }
        $form = $formModel->getValue();
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_FORGOT_PASSWORD));
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX));
        $form->setCaptchaUrl($urlCreator->createUrl(You_Dzit_Constants::ACTION_CAPTCHA, Array(), Array('key'=>self::CAPTCHA_KEY)));

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_CAPTCHA;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_EMAIL;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_LOGIN_NAME;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, strtolower($value));
        }

        return $form;
    }
}
?>

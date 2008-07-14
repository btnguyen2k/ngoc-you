<?php
require_once 'includes/captcha.php';
require_once 'includes/utils.php';
require_once 'dao/dbUtils.php';
require_once 'dao/ClassUser.php';

class You_Dzit_RegisterHandler extends You_Dzit_BaseActionHandler {

    const CAPTCHA_KEY                   = 'CAPTCHA_REGISTER';
    const FORM_FIELD_LOGIN_NAME         = 'loginName';
    const FORM_FIELD_PASSWORD           = 'password';
    const FORM_FIELD_CONFIRMED_PASSWORD = 'confirmedPassword';
    const FORM_FIELD_EMAIL              = 'email';
    const FORM_FIELD_FULL_NAME          = 'fullName';
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
            $pwd = $form->getField(self::FORM_FIELD_PASSWORD);
            $pwdConfirmed = $form->getField(self::FORM_FIELD_CONFIRMED_PASSWORD);
            $email = $form->getField(self::FORM_FIELD_EMAIL);
            $fullName = $form->getField(self::FORM_FIELD_FULL_NAME);
            $captcha = $form->getField(self::FORM_FIELD_CAPTCHA);

            if ( $loginName === "" ) {
                $form->addErrorMessage($lang->getMessage('error.emptyLoginName'));
            }
            if ( $pwd === "" ) {
                $form->addErrorMessage($lang->getMessage('error.emptyPassword'));
            }
            if ( $pwd !== $pwdConfirmed ) {
                $form->addErrorMessage($lang->getMessage('error.confirmedPasswordNotMatch'));
            }
            if ( $email === "" ) {
                $form->addErrorMessage($lang->getMessage('error.emptyEmail'));
            }
            if ( getUserByLoginName($loginName) !== NULL ) {
                $form->addErrorMessage($lang->getMessage('error.loginNameAlreadyExists'));
            }
            if ( getUserByEmail($email) !== NULL ) {
                $form->addErrorMessage($lang->getMessage('error.emailAlreadyExists'));
            }
            if ( $captcha !== captchaGetCode(self::CAPTCHA_KEY) ) {
                $form->addErrorMessage($lang->getMessage('error.captchaCodeNotMatch'));
            }
            if ( !$form->hasErrorMessage() ) {
                $activationCode = strtolower(md5(mt_rand(0, time())));
                $user = new User();
                $user->setActivationCode($activationCode);
                $user->setEmail($email);
                $user->setFullName($fullName);
                $user->setGroupId(GROUP_MEMBER);
                $user->setLoginName($loginName);
                $user->setPassword($pwd);
                $user = createUser($user);
                captchaDelete(self::CAPTCHA_KEY);

                $app = $this->getApplication();
                $urlCreator = $app->getUrlCreator();
                
                $subject = $lang->getMessage('email.register.subject');
                $body = $lang->getMessage('email.register.body');                
                $site = '<a href="'.$urlCreator->getHomeUrl(true).'">'.$app->getYouProperty('you.site.name').'</a>';
                $body = str_replace('{SITE}', $site, $body);
                $body = str_replace('{LOGIN_NAME}', $user->getLoginName(), $body);
                $body = str_replace('{FULL_NAME}', $user->getFullName(), $body);
                $body = str_replace('{EMAIL_ADMINISTRATOR}', $app->getYouProperty('you.administrator.email'), $body);
                $urlActivate = $urlCreator->createUrl(
                    You_Dzit_Constants::ACTION_MEMBER_ACTIVATE_ACCOUNT,
                    Array(),
                    Array('id' => $user->getId(), 'activationCode' => $user->getActivationCode()),
                    "",
                    true
                );
                $body = str_replace('{URL_ACTIVATE_ACCOUNT}', "<a href=\"$urlActivate\">$urlActivate</a>", $body);
                sendEmail($app->getYouProperty('you.email.outgoing'), $user->getEmail(), $subject, $body, true);
                echo 'hehehe';
                $result = new Ddth_Dzit_ControlForward_UrlRedirectControlForward($urlCreator->createUrl(
                        You_Dzit_Constants::ACTION_MEMBER_REGISTER_DONE,
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
            $form = new You_DataModel_Form('frmRegister');
            $formModel = new Ddth_Template_DataModel_Bean(You_Dzit_Constants::DATA_MODEL_FORM, $form);
            $this->populateRootDataModel(You_Dzit_Constants::DATA_MODEL_FORM, $formModel);
        }
        $form = $formModel->getValue();
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $form->setAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_MEMBER_REGISTER));
        $form->setCancelAction($urlCreator->createUrl(You_Dzit_Constants::ACTION_INDEX));
        $form->setCaptchaUrl($urlCreator->createUrl(You_Dzit_Constants::ACTION_CAPTCHA, Array(), Array('key'=>self::CAPTCHA_KEY)));

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $field = self::FORM_FIELD_CAPTCHA;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_CONFIRMED_PASSWORD;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_EMAIL;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_FULL_NAME;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);

            $field = self::FORM_FIELD_LOGIN_NAME;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, strtolower($value));

            $field = self::FORM_FIELD_PASSWORD;
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
            $form->setField($field, $value);
        }

        return $form;
    }
}
?>

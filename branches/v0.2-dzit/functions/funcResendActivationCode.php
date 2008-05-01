<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/captcha.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_LOGIN_NAME", "loginName");
//define("FORM_FIELD_PASSWORD", "password");
define("FORM_FIELD_EMAIL", "email");
define("FORM_FIELD_CAPTCHA", "captcha");
define("CAPTCHA_KEY", "CAPTCHA_RESEND_ACTIVATION_CODE");

$PAGE = Array();
$siteConfig = getAllConfigs();
$PAGE['config'] = $siteConfig;
$PAGE['captchaKey'] = CAPTCHA_KEY;
$PAGE['pageTitle'] = APPLICATION_NAME.' - Resend Activation Code';
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_RESEND_ACTIVATION_CODE;
$PAGE['form']['fieldLoginName'] = FORM_FIELD_LOGIN_NAME;
//$PAGE['form']['fieldPassword'] = FORM_FIELD_PASSWORD;
$PAGE['form']['fieldEmail'] = FORM_FIELD_EMAIL;
$PAGE['form']['fieldCaptcha'] = FORM_FIELD_CAPTCHA;
$PAGE['form']['valueLoginName'] = '';
$PAGE['form']['valueEmail'] = '';
$PAGE['form']['errorMessage'] = '';
$PAGE['form']['informationMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    captchaCreate(CAPTCHA_KEY);
} else {
    $loginName = isset($_POST[FORM_FIELD_LOGIN_NAME])
    ? strtolower(trim($_POST[FORM_FIELD_LOGIN_NAME])) : "";
    $user = getUserByLoginName($loginName);
    //    $pwd = isset($_POST[FORM_FIELD_PASSWORD])
    //    ? trim($_POST[FORM_FIELD_PASSWORD]) : "";
    $email = isset($_POST[FORM_FIELD_EMAIL])
    ? strtolower(trim($_POST[FORM_FIELD_EMAIL])) : "";
    $securityCode = isset($_POST[FORM_FIELD_CAPTCHA])
    ? trim($_POST[FORM_FIELD_CAPTCHA]) : "";
    $PAGE['form']['valueLoginName'] = $loginName;
    $PAGE['form']['valueEmail'] = $email;
    if ( $user === NULL ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_USER_NOT_FOUND'];
    } elseif ( $user->getEmail() !== $email ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_EMAIL_NOT_MATCH'];
    } elseif ( $user->isActivated() ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_ACCOUNT_ALREADY_ACTIVATED'];
    } elseif ( $securityCode !== captchaGetCode(CAPTCHA_KEY) ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_SECURITY_CODE_NOT_MATCH'];
    } else {
        $activationCode = $user->getActivationCode();
        captchaDelete(CAPTCHA_KEY);
        $subject = $LANG['REGISTER_EMAIL_SUBJECT'];
        $body = $LANG['REGISTER_EMAIL_BODY'];
        $site = '<a href="'.getSiteUrl().'">'.$siteConfig['SITE_NAME'].'</a>';
        $body = str_replace('{SITE}', $site, $body);
        $body = str_replace('{LOGIN_NAME}', $user->getLoginName(), $body);
        $body = str_replace('{FULL_NAME}', $user->getFullName(), $body);
        $body = str_replace('{EMAIL_ADMINISTRATOR}', $siteConfig['EMAIL_ADMINISTRATOR'], $body);
        $urlActivate = getSiteUrl().'/index.php?'.GET_PARAM_ACTION.'='.ACTION_ACTIVATE_ACCOUNT;
        $urlActivate .= '&id='.$user->getId().'&activationCode='.$user->getActivationCode();
        $body = str_replace('{URL_ACTIVATE_ACCOUNT}', "<a href=\"$urlActivate\">$urlActivate</a>", $body);
        sendEmail($siteConfig['EMAIL_OUTGOING'], $user->getEmail(), $subject, $body, true);
        $params = GET_PARAM_ACTION.'='.ACTION_RESEND_ACTIVATION_CODE_DONE;
        $params .= '&'.GET_PARAM_ID.'='.$user->getId();
        header("Location: index.php?".$params);
    }
}

require_once 'templates/'.TEMPLATE.'/pageResendActivationCode.php';
?>
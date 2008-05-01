<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/captcha.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_LOGIN_NAME", "loginName");
define("FORM_FIELD_PASSWORD", "password");
define("FORM_FIELD_CONFIRMED_PASSWORD", "confirmedPassword");
define("FORM_FIELD_EMAIL", "email");
define("FORM_FIELD_FULL_NAME", "fullName");
define("FORM_FIELD_CAPTCHA", "captcha");
define("CAPTCHA_KEY", "CAPTCHA_REGISTER");

$PAGE = Array();
$siteConfig = getAllConfigs();
$PAGE['config'] = $siteConfig;
$PAGE['captchaKey'] = CAPTCHA_KEY;
$PAGE['pageTitle'] = APPLICATION_NAME.' - Register';
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_REGISTER;
$PAGE['form']['fieldLoginName'] = FORM_FIELD_LOGIN_NAME;
$PAGE['form']['fieldPassword'] = FORM_FIELD_PASSWORD;
$PAGE['form']['fieldConfirmedPassword'] = FORM_FIELD_CONFIRMED_PASSWORD;
$PAGE['form']['fieldEmail'] = FORM_FIELD_EMAIL;
$PAGE['form']['fieldFullName'] = FORM_FIELD_FULL_NAME;
$PAGE['form']['fieldCaptcha'] = FORM_FIELD_CAPTCHA;
$PAGE['form']['valueLoginName'] = '';
$PAGE['form']['valueEmail'] = '';
$PAGE['form']['valueFullName'] = '';
$PAGE['form']['errorMessage'] = '';
$PAGE['form']['informationMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    captchaCreate(CAPTCHA_KEY);
} else {
    $loginName = isset($_POST[FORM_FIELD_LOGIN_NAME])
    ? strtolower(trim($_POST[FORM_FIELD_LOGIN_NAME])) : "";
    $pwd = isset($_POST[FORM_FIELD_PASSWORD])
    ? trim($_POST[FORM_FIELD_PASSWORD]) : "";
    $pwdConfirmed = isset($_POST[FORM_FIELD_CONFIRMED_PASSWORD])
    ? trim($_POST[FORM_FIELD_CONFIRMED_PASSWORD]) : "";
    $email = isset($_POST[FORM_FIELD_EMAIL])
    ? trim($_POST[FORM_FIELD_EMAIL]) : "";
    $fullName = isset($_POST[FORM_FIELD_FULL_NAME])
    ? trim($_POST[FORM_FIELD_FULL_NAME]) : "";
    $securityCode = isset($_POST[FORM_FIELD_CAPTCHA])
    ? trim($_POST[FORM_FIELD_CAPTCHA]) : "";
    $PAGE['form']['valueLoginName'] = $loginName;
    $PAGE['form']['valueEmail'] = $email;
    $PAGE['form']['valueFullName'] = $fullName;
    if ( $loginName === "" ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_LOGIN_NAME'];
    } elseif ( $pwd === "" ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_PASSWORD'];
    } elseif ( $pwd !== $pwdConfirmed ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_CONFIRMED_PASSWORD_NOT_MATCH'];
    } elseif ( $email === "" ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_EMAIL'];
    } elseif ( getUserByLoginName($loginName) !== NULL ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_LOGIN_NAME_ALREADY_EXISTS'];
    } elseif ( getUserByEmail($email) !== NULL ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_EMAIL_ALREADY_EXISTS'];
    } elseif ( $securityCode !== captchaGetCode(CAPTCHA_KEY) ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_SECURITY_CODE_NOT_MATCH'];
    } else {
        $activationCode = strtolower(md5(mt_rand(0, time())));
        $user = new User();
        $user->setActivationCode($activationCode);
        $user->setEmail($email);
        $user->setFullName($fullName);
        $user->setGroupId(GROUP_MEMBER);
        $user->setLoginName($loginName);
        $user->setPassword($pwd);
        $user = createUser($user);
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
        $params = GET_PARAM_ACTION.'='.ACTION_REGISTER_DONE;
        $params .= '&'.GET_PARAM_ID.'='.$user->getId();
        header("Location: index.php?".$params);
    }
}

require_once 'templates/'.TEMPLATE.'/pageRegister.php';
?>
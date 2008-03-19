<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/captcha.php';
require_once 'dao/dbUtils.php';

if ( $CURRENT_USER === NULL ) {
    header("Location: index.php?".GET_PARAM_ACTION."=".ACTION_LOGIN);
    return;
}

define("FORM_FIELD_ADS_ID", "adsId");
define("FORM_FIELD_CAPTCHA", "captcha");
define("CAPTCHA_KEY", "CAPTCHA_REPORT_ADS");

$id = 0;
if ( isset($_POST[FORM_FIELD_ADS_ID]) ) {
    $id = $_POST[FORM_FIELD_ADS_ID] + 0;
} elseif ( isset($_GET[GET_PARAM_ID]) ) {
    $id = $_GET[GET_PARAM_ID] + 0;
}
$ads = getEntry($id);
if ( $ads !== NULL && $ads->isExpired() ) $ads = NULL;
$cat = $ads!==NULL ? getCategory($ads->getCategoryId()) : NULL;

$PAGE = Array();
$PAGE['captchaKey'] = CAPTCHA_KEY;
$PAGE['pageTitle'] = APPLICATION_NAME.' - '.($ads!==NULL?htmlspecialchars($ads->getTitle()):"");
$PAGE['category'] = $cat;
$PAGE['ads'] = $ads;
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_REPORT_ADS;
$PAGE['form']['fieldAdsId'] = FORM_FIELD_ADS_ID;
$PAGE['form']['fieldCaptcha'] = FORM_FIELD_CAPTCHA;
$PAGE['form']['valueAdsId'] = $id;
$PAGE['form']['errorMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    captchaCreate(CAPTCHA_KEY);
} else {
    $securityCode = isset($_POST[FORM_FIELD_CAPTCHA]) ? trim($_POST[FORM_FIELD_CAPTCHA]) : "";
    if ( $securityCode !== captchaGetCode(CAPTCHA_KEY) ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_SECURITY_CODE_NOT_MATCH'];
    } else {
        if ( $ads !== NULL ) {
            reportEntry($ads, $CURRENT_USER);
        }
        $url = 'index.php?'.GET_PARAM_ACTION.'='.ACTION_REPORT_ADS_DONE.'&'.GET_PARAM_ID.'='.$ads->getId();
        header('Location: '.$url);
        return;
    }
}

require_once 'templates/'.TEMPLATE.'/pageReportAds.php';
?>
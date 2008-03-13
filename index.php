<?php
session_start();
define("NGOC.YOU", 1);
require_once 'includes/includeSetup.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';
require_once 'languages/lang_'.LANGUAGE.'.php';

define("DEFAULT_ACTION", 'index');
define("ACTION_LOGIN", 'login');
define("ACTION_LOGOUT", 'logout');
define("ACTION_VIEW_CAT", 'viewCat');
define("ACTION_VIEW_ADS", 'viewAds');
define("ACTION_CONTACT_POSTER", 'contactPoster');
define("ACTION_CONTACT_POSTER_DONE", 'contactPosterDone');
define("ACTION_REGISTER", 'register');
define("ACTION_REGISTER_DONE", 'registerDone');
define("ACTION_RSS_CAT", 'rssCat');
define("ACTION_THUMBNAIL", 'thumbnail');
define("ACTION_VIEW_ATTACHMENT", 'viewAttachment');
define("ACTION_CAPTCHA", 'captcha');
define("ACTION_ACTIVATE_ACCOUNT", 'activateAccount');
define("ACTION_RESEND_ACTIVATION_CODE", 'resendActivationCode');
define("ACTION_RESEND_ACTIVATION_CODE_DONE", 'resendActivationCodeDone');

$CURRENT_USER = NULL;
if ( isset($_SESSION[SESSION_CURRENT_USER_ID]) ) {
	$CURRENT_USER = getUser($_SESSION[SESSION_CURRENT_USER_ID]);
}

$ACTION = isset($_GET[GET_PARAM_ACTION])?$_GET[GET_PARAM_ACTION]:DEFAULT_ACTION;
$ACTION = trim($ACTION);

if ( $ACTION === ACTION_LOGIN ) {
	require_once 'functions/funcLogin.php';	
} elseif ( $ACTION === ACTION_LOGOUT ) {
	require_once 'functions/funcLogout.php';	
} elseif ( $ACTION === ACTION_REGISTER ) {
	require_once 'functions/funcRegister.php';	
} elseif ( $ACTION === ACTION_REGISTER_DONE ) {
    unset($_SESSION[SESSION_LAST_ACCESS_PAGE]);
	require_once 'functions/funcRegisterDone.php';	
} elseif ( $ACTION === ACTION_VIEW_CAT ) {
    $_SESSION[SESSION_LAST_ACCESS_PAGE] = $_SERVER["REQUEST_URI"];
	require_once 'functions/funcViewCat.php';	
} elseif ( $ACTION === ACTION_VIEW_ADS ) {
    $_SESSION[SESSION_LAST_ACCESS_PAGE] = $_SERVER["REQUEST_URI"];
	require_once 'functions/funcViewAds.php';	
} elseif ( $ACTION === ACTION_RSS_CAT ) {
    unset($_SESSION[SESSION_LAST_ACCESS_PAGE]);
	require_once 'functions/funcRssCat.php';	
} elseif ( $ACTION === ACTION_CONTACT_POSTER ) {
    $_SESSION[SESSION_LAST_ACCESS_PAGE] = $_SERVER["REQUEST_URI"];
	require_once 'functions/funcContactPoster.php';	
} elseif ( $ACTION === ACTION_CONTACT_POSTER_DONE ) {
    unset($_SESSION[SESSION_LAST_ACCESS_PAGE]);
	require_once 'functions/funcContactPosterDone.php';	
} elseif ( $ACTION === ACTION_THUMBNAIL ) {
 	require_once 'functions/funcThumbnail.php';	
} elseif ( $ACTION === ACTION_VIEW_ATTACHMENT ) {
 	require_once 'functions/funcViewAttachment.php';	
} elseif ( $ACTION === ACTION_CAPTCHA ) {
 	require_once 'functions/funcDisplayCaptcha.php';	
} elseif ( $ACTION === ACTION_ACTIVATE_ACCOUNT ) {
	require_once 'functions/funcActivateAccount.php';	
} elseif ( $ACTION === ACTION_RESEND_ACTIVATION_CODE ) {
	require_once 'functions/funcResendActivationCode.php';	
} elseif ( $ACTION === ACTION_RESEND_ACTIVATION_CODE_DONE ) {
	require_once 'functions/funcResendActivationCodeDone.php';	
} else {
    $_SESSION[SESSION_LAST_ACCESS_PAGE] = $_SERVER["REQUEST_URI"];
	require_once 'functions/funcIndex.php';	
}
?>
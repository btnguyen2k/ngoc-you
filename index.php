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
define("ACTION_REGISTER", 'register');
define("ACTION_REGISTER_DONE", 'registerDone');

$CURRENT_USER = NULL;
if ( isset($_SESSION[SESSION_CURRENT_USER_ID]) ) {
	$CURRENT_USER = getUser($_SESSION[SESSION_CURRENT_USER_ID]);
}

$ACTION = isset($_GET[GET_PARAM_ACTION])?$_GET[GET_PARAM_ACTION]:DEFAULT_ACTION;
$ACTION = trim($ACTION);

if ( $ACTION == ACTION_LOGIN ) {
	require_once 'functions/funcLogin.php';	
} elseif ( $ACTION == ACTION_LOGOUT ) {
	require_once 'functions/funcLogout.php';	
} elseif ( $ACTION == ACTION_REGISTER ) {
	require_once 'functions/funcRegister.php';	
} elseif ( $ACTION == ACTION_REGISTER_DONE ) {
	require_once 'functions/funcRegisterDone.php';	
} elseif ( $ACTION == ACTION_VIEW_CAT ) {
	require_once 'functions/funcViewCat.php';	
} elseif ( $ACTION == ACTION_VIEW_ADS ) {
	require_once 'functions/funcViewAds.php';	
} else {
	require_once 'functions/funcIndex.php';	
}
?>
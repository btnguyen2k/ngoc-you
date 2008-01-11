<?php
session_start();
define("NGOC.YOU", 1);
require_once 'includes/includeSetup.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';
require_once 'languages/lang_'.LANGUAGE.'.php';

define("ACTION_DEFAULT", 'index');
define("ACTION_LOGIN", 'login');
define("ACTION_LOGOUT", 'logout');
define("ACTION_CHANGE_FULL_NAME", 'changeFullName');
define("ACTION_CHANGE_EMAIL", 'changeEmail');

$ACTION = isset($_GET[GET_PARAM_ACTION])?$_GET[GET_PARAM_ACTION]:ACTION_DEFAULT;
$ACTION = trim($ACTION);
$CURRENT_USER = NULL;

if ( !isset($_SESSION[SESSION_CURRENT_USER_ID]) ) {
	$ACTION = ACTION_LOGIN;
} else {
	 $CURRENT_USER = getUser($_SESSION[SESSION_CURRENT_USER_ID]);
	 if ( $CURRENT_USER == NULL ) {
	 	$ACTION = ACTION_LOGIN;
	 }
}

if ( $ACTION == ACTION_LOGIN ) {
	require_once 'functions/myprofile/funcLogin.php';	
} elseif ( $ACTION == ACTION_LOGOUT ) {
	require_once 'functions/myprofile/funcLogout.php';	
} else {
	require_once 'functions/myprofile/funcIndex.php';
}
?>
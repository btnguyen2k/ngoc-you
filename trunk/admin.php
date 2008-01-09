<?php
session_start();
define("NGOC.YOU", 1);
require_once 'includes/includeSetup.php';
require_once 'includes/config.php';
require_once 'languages/lang_'.LANGUAGE.'.php';

define("GET_PARAM_ACTION", 'act');
define("GET_PARAM_CATEGORY", 'cat');

define("SESSION_ADMIN_ACCOUNT", 'ADMIN_ACCOUNT');

define("ACTION_DEFAULT", 'index');
define("ACTION_LOGIN", 'login');
define("ACTION_LOGOUT", 'logout');
define("ACTION_CAT_MANAGEMENT", 'catManagement');
define("ACTION_CREATE_CAT", 'createCat');
define("ACTION_EDIT_CAT", 'editCat');
define("ACTION_DELETE_CAT", 'deleteCat');
define("ACTION_MOVE_UP_CAT", 'moveUpCat');
define("ACTION_MOVE_DOWN_CAT", 'moveDownCat');
define("ACTION_USER_MANAGEMENT", 'userManagement');

$ACTION = isset($_GET[GET_PARAM_ACTION])?$_GET[GET_PARAM_ACTION]:ACTION_DEFAULT;
$ACTION = trim($ACTION);

if ( !isset($_SESSION[SESSION_ADMIN_ACCOUNT]) ) {
	$ACTION = ACTION_LOGIN;
} 

if ( $ACTION == ACTION_LOGIN ) {
	require_once 'functions/admin/funcLogin.php';	
} elseif ( $ACTION == ACTION_CAT_MANAGEMENT ) {
	require_once 'functions/admin/funcCatManagement.php';
} elseif ( $ACTION == ACTION_CREATE_CAT ) {
	require_once 'functions/admin/funcCreateCat.php';
} elseif ( $ACTION == ACTION_EDIT_CAT ) {
	require_once 'functions/admin/funcEditCat.php';
} else {
	require_once 'functions/admin/funcIndex.php';
}
?>
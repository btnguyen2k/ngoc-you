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
define("ACTION_CAT_MANAGEMENT", 'catManagement');
define("ACTION_CREATE_CAT", 'createCat');
define("ACTION_EDIT_CAT", 'editCat');
define("ACTION_DELETE_CAT", 'deleteCat');
define("ACTION_MOVE_UP_CAT", 'moveUpCat');
define("ACTION_MOVE_DOWN_CAT", 'moveDownCat');
define("ACTION_USER_MANAGEMENT", 'userManagement');

$ACTION = isset($_GET[GET_PARAM_ACTION])?$_GET[GET_PARAM_ACTION]:ACTION_DEFAULT;
$ACTION = trim($ACTION);
$CURRENT_USER = NULL;

if ( !isset($_SESSION[SESSION_CURRENT_USER_ID]) ) {
	$ACTION = ACTION_LOGIN;
} else {
	 $CURRENT_USER = getUser($_SESSION[SESSION_CURRENT_USER_ID]);
	 if ( $CURRENT_USER === NULL 
	 		|| ($CURRENT_USER->getGroupId() !== GROUP_ADMINISTRATOR
	 		    && $CURRENT_USER->getGroupId() !== GROUP_MODERATOR) ) {
	 	$ACTION = ACTION_LOGIN;
	 }
}

unset($_SESSION[SESSION_LAST_ACCESS_PAGE]);
if ( $ACTION === ACTION_LOGIN ) {
	require_once 'functions/admin/funcLogin.php';	
} elseif ( $ACTION === ACTION_LOGOUT ) {
	require_once 'functions/admin/funcLogout.php';	
} elseif ( $ACTION === ACTION_CAT_MANAGEMENT ) {
	require_once 'functions/admin/funcCatManagement.php';
} elseif ( $ACTION === ACTION_CREATE_CAT ) {
	require_once 'functions/admin/funcCreateCat.php';
} elseif ( $ACTION === ACTION_DELETE_CAT ) {
	require_once 'functions/admin/funcDeleteCat.php';
} elseif ( $ACTION === ACTION_EDIT_CAT ) {
	require_once 'functions/admin/funcEditCat.php';
} elseif ( $ACTION === ACTION_MOVE_UP_CAT ) {
	require_once 'functions/admin/funcMoveUpCat.php';
} elseif ( $ACTION === ACTION_MOVE_DOWN_CAT ) {
	require_once 'functions/admin/funcMoveDownCat.php';
} else {
	require_once 'functions/admin/funcIndex.php';
}
?>
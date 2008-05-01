<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_LOGIN_NAME", "loginName");
define("FORM_FIELD_PASSWORD", "password");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - My Profile/Login';
$PAGE['form'] = Array();
$PAGE['form']['fieldLoginName'] = FORM_FIELD_LOGIN_NAME;
$PAGE['form']['fieldPassword'] = FORM_FIELD_PASSWORD;
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGIN;
$PAGE['form']['errorMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$loginName = isset($_POST[FORM_FIELD_LOGIN_NAME])
		? $_POST[FORM_FIELD_LOGIN_NAME] : "";
	$password = isset($_POST[FORM_FIELD_PASSWORD])
		? $_POST[FORM_FIELD_PASSWORD] : "";
	$user = getUserByLoginName($loginName);
	if ( $user === NULL || !$user->authenticate($password) ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_LOGIN_FAILED'];
	} elseif ( !$user->isActivated() ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_ACCOUNT_NOT_ACTIVATED'];
    } else {
		$_SESSION[SESSION_CURRENT_USER_ID] = $user->getId();
		header('Location: myprofile.php');
		return;
	}
}

require_once 'templates/'.TEMPLATE.'/myprofile/pageLogin.php';
?>
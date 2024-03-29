<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_LOGIN_NAME", "loginName");
define("FORM_FIELD_PASSWORD", "password");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Login';
$PAGE['form'] = Array();
$PAGE['form']['fieldLoginName'] = FORM_FIELD_LOGIN_NAME;
$PAGE['form']['fieldPassword'] = FORM_FIELD_PASSWORD;
$PAGE['form']['action'] = 'admin.php?'.GET_PARAM_ACTION.'='.ACTION_LOGIN;
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
    } elseif ( $user->getGroupId() !== GROUP_ADMINISTRATOR && $user->getGroupId() !== GROUP_MODERATOR ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_NO_PERMISSION'];
    } else {
		$_SESSION[SESSION_CURRENT_USER_ID] = $user->getId();
		header('Location: admin.php');
		return;
	}
}

require_once 'templates/'.TEMPLATE.'/admin/pageLogin.php';
?>
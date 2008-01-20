<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_CURRENT_PASSWORD", "currentPassword");
define("FORM_FIELD_NEW_PASSWORD", "newPassword");
define("FORM_FIELD_CONFIRMED_NEW_PASSWORD", "confirmedNewPassword");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Register';
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_REGISTER;
$PAGE['form']['fieldCurrentPassword'] = FORM_FIELD_CURRENT_PASSWORD;
$PAGE['form']['fieldNewPassword'] = FORM_FIELD_NEW_PASSWORD;
$PAGE['form']['fieldConfirmedNewPassword'] = FORM_FIELD_CONFIRMED_NEW_PASSWORD;
$PAGE['form']['errorMessage'] = '';
$PAGE['form']['informationMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	/*
	$currentPwd = isset($_POST[FORM_FIELD_CURRENT_PASSWORD])
		? trim($_POST[FORM_FIELD_CURRENT_PASSWORD]) : "";
	$newPwd = isset($_POST[FORM_FIELD_NEW_PASSWORD])
		? trim($_POST[FORM_FIELD_NEW_PASSWORD]) : "";
	$newPwdConfirmed = isset($_POST[FORM_FIELD_CONFIRMED_NEW_PASSWORD])
		? trim($_POST[FORM_FIELD_CONFIRMED_NEW_PASSWORD]) : "";
	if ( !$CURRENT_USER->authenticate($currentPwd) ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_PASSWORD_NOT_MATCH'];
	} elseif ( $newPwd == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_NEW_PASSWORD'];
	} elseif ( $newPwd != $newPwdConfirmed ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_CONFIRMED_PASSWORD_NOT_MATCH'];
	} else {
		$CURRENT_USER->setPassword($CURRENT_USER->encryptPassword($newPwd));
		$PAGE['form']['informationMessage'] = $LANG['INFO_PASSWORD_CHANGED'];
		updateUser($CURRENT_USER);
	}
	*/
}

require_once 'templates/'.TEMPLATE.'/pageRegister.php';
?>
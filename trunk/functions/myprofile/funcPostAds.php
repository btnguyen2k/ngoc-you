<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_CURRENT_PASSWORD", "currentPassword");
define("FORM_FIELD_NEW_FULL_NAME", "newFullName");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - My Profile/Change Full Name';
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CHANGE_FULL_NAME;
$PAGE['form']['fieldCurrentPassword'] = FORM_FIELD_CURRENT_PASSWORD;
$PAGE['form']['fieldNewFullName'] = FORM_FIELD_NEW_FULL_NAME;
$PAGE['form']['valueNewFullName'] = $CURRENT_USER->getFullName();
$PAGE['form']['errorMessage'] = '';
$PAGE['form']['informationMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$currentPwd = isset($_POST[FORM_FIELD_CURRENT_PASSWORD])
		? trim($_POST[FORM_FIELD_CURRENT_PASSWORD]) : "";
	$newFullName = isset($_POST[FORM_FIELD_NEW_FULL_NAME])
		? trim($_POST[FORM_FIELD_NEW_FULL_NAME]) : "";
	$PAGE['form']['valueNewFullName'] = $newFullName;
	if ( !$CURRENT_USER->authenticate($currentPwd) ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_PASSWORD_NOT_MATCH'];
	} elseif ( $newFullName == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_NEW_FULL_NAME'];
	} else {
		$CURRENT_USER->setFullName($newFullName);
		$PAGE['form']['informationMessage'] = $LANG['INFO_FULL_NAME_CHANGED'];
		updateUser($CURRENT_USER);
	}
}

require_once 'templates/'.TEMPLATE.'/myprofile/pagePostAds.php';
?>
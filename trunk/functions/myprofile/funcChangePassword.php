<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_CURRENT_PASSWORD", "currentPassword");
define("FORM_FIELD_NEW_PASSWORD", "newPassword");
define("FORM_FIELD_CONFIRMED_NEW_PASSWORD", "confirmedNewPassword");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - My Profile/Change Password';
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CHANGE_PASSWORD;
$PAGE['form']['fieldCurrentPassword'] = FORM_FIELD_CURRENT_PASSWORD;
$PAGE['form']['fieldNewPassword'] = FORM_FIELD_NEW_PASSWORD;
$PAGE['form']['fieldConfirmedNewPassword'] = FORM_FIELD_CONFIRMED_NEW_PASSWORD;
$PAGE['form']['errorMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	/*
	$catName = isset($_POST[FORM_FIELD_CAT_NAME])
		? $_POST[FORM_FIELD_CAT_NAME] : "";
	$catDesc = isset($_POST[FORM_FIELD_CAT_DESC])
		? $_POST[FORM_FIELD_CAT_DESC] : "";
	$catParentId = isset($_POST[FORM_FIELD_PARENT_CAT_ID])
		? $_POST[FORM_FIELD_PARENT_CAT_ID] : 0;
	$catParentId += 0;
	$catName = trim($catName);
	$catDesc = trim($catDesc);
	$PAGE['form']['valueCategoryName'] = $catName;
	$PAGE['form']['valueCategoryDescription'] = $catDesc;
	$PAGE['form']['valueParentCategoryId'] = $catParentId;
	if ( $catName == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_CATEGORY_NAME'];
	} else {
		$parent = getCategory($catParentId);
		$cat = createCategory($catName, $catDesc, $parent);
		header('Location: admin.php?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT);
		return;	
	}
	*/
}

require_once 'templates/'.TEMPLATE.'/myprofile/pageChangePassword.php';
?>
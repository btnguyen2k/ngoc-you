<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_PARENT_CAT_ID", "parentId");
define("FORM_FIELD_CAT_NAME", "name");
define("FORM_FIELD_CAT_DESC", "desc");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Create Category';
$PAGE['categories'] = getAllCategories();
$PAGE['form'] = Array();
$PAGE['form']['action'] = 'admin.php?'.GET_PARAM_ACTION.'='.ACTION_CREATE_CAT;
$PAGE['form']['fieldCategoryParentId'] = FORM_FIELD_PARENT_CAT_ID;
$PAGE['form']['fieldCategoryName'] = FORM_FIELD_CAT_NAME;
$PAGE['form']['fieldCategoryDescription'] = FORM_FIELD_CAT_DESC;
$PAGE['form']['valueCategoryName'] = '';
$PAGE['form']['valueCategoryDescription'] = '';
$PAGE['form']['valueParentCategoryId'] = 0;
$PAGE['form']['errorMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
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
		header('Location: admin.php?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT);
		return;	
	}
}

require_once 'templates/'.TEMPLATE.'/admin/pageCreateCat.php';
?>
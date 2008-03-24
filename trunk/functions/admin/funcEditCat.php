<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

require_once 'adminCommons.php';
adminCheckPermission(PERM_EDIT_CATEGORY);

define("FORM_FIELD_PARENT_CAT_ID", "parentId");
define("FORM_FIELD_CAT_ID", "id");
define("FORM_FIELD_CAT_NAME", "name");
define("FORM_FIELD_CAT_DESC", "desc");

$id = 0;
if ( isset($_POST[FORM_FIELD_CAT_ID]) ) {
	$id = $_POST[FORM_FIELD_CAT_ID] + 0;
} elseif ( isset($_GET[GET_PARAM_CATEGORY]) ) {
	$id = $_GET[GET_PARAM_CATEGORY] + 0;
}
$cat = getCategory($id);

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Edit Category';
$PAGE['categoryTree'] = getCategoryTree();
$PAGE['category'] = $cat;
$PAGE['form'] = Array();
$PAGE['form']['action'] = 'admin.php?'.GET_PARAM_ACTION.'='.ACTION_EDIT_CAT;
$PAGE['form']['fieldCategoryId'] = FORM_FIELD_CAT_ID;
$PAGE['form']['fieldCategoryParentId'] = FORM_FIELD_PARENT_CAT_ID;
$PAGE['form']['fieldCategoryName'] = FORM_FIELD_CAT_NAME;
$PAGE['form']['fieldCategoryDescription'] = FORM_FIELD_CAT_DESC;
$PAGE['form']['valueCategoryId'] = $id;
$PAGE['form']['valueParentCategoryId'] = $cat !== NULL ? $cat->getParentId() : 0;
$PAGE['form']['valueCategoryName'] = $cat !== NULL ? $cat->getName() : '';
$PAGE['form']['valueCategoryDescription'] = $cat !== NULL ? $cat->getDescription() : '';
$PAGE['form']['errorMessage'] = '';

if ( $cat !== NULL && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
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
	if ( $catName === "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_CATEGORY_NAME'];
	} else {
		$parent = getCategory($catParentId);
		if ( $cat->getNumChildren() > 0 || $parent === NULL ) {
			$cat->setParentId(0);
		} elseif ( $catParentId !== $cat->getId() ) {
			$cat->setParentId($catParentId);
		}
		$cat->setName($catName);
		$cat->setDescription($catDesc);
		updateCategory($cat);
		header('Location: admin.php?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT);
		return;	
	}
}

require_once 'templates/'.TEMPLATE.'/admin/pageEditCat.php';
?>
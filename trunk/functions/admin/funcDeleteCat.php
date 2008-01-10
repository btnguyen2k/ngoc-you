<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_CAT_ID", "id");

$id = 0;
if ( isset($_POST[FORM_FIELD_CAT_ID]) ) {
	$id = $_POST[FORM_FIELD_CAT_ID] + 0;
} elseif ( isset($_GET[GET_PARAM_CATEGORY]) ) {
	$id = $_GET[GET_PARAM_CATEGORY] + 0;
}
$cat = getCategory($id);

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Delete Category';
$PAGE['categoryTree'] = getCategoryTree();
$PAGE['category'] = $cat;
$PAGE['form'] = Array();
$PAGE['form']['action'] = 'admin.php?'.GET_PARAM_ACTION.'='.ACTION_DELETE_CAT;
$PAGE['form']['fieldCategoryId'] = FORM_FIELD_CAT_ID;
$PAGE['form']['valueCategoryId'] = $id;

if ( $cat != NULL && $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	deleteCategory($cat->getId());
	header('Location: admin.php?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT);
	return;	
}

require_once 'templates/'.TEMPLATE.'/admin/pageDeleteCat.php';
?>
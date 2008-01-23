<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_CATEGORY", "category");
define("FORM_FIELD_ADS_TITLE", "adsTitle");
define("FORM_FIELD_ADS_CONTENT", "adsContent");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - My Profile/Post to Classifieds';
$PAGE['categoryTree'] = getCategoryTree();
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_POST_ADS;
$PAGE['form']['fieldCategory'] = FORM_FIELD_CATEGORY;
$PAGE['form']['fieldAdsTitle'] = FORM_FIELD_ADS_TITLE;
$PAGE['form']['fieldAdsContent'] = FORM_FIELD_ADS_CONTENT;
$PAGE['form']['valueCategory'] = 0;
$PAGE['form']['valueAdsTitle'] = '';
$PAGE['form']['valueAdsContent'] = '';
$PAGE['form']['errorMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$categoryId = isset($_POST[FORM_FIELD_CATEGORY])
		? $_POST[FORM_FIELD_CATEGORY]+0 : 0;
	$adsTitle = isset($_POST[FORM_FIELD_ADS_TITLE])
		? trim($_POST[FORM_FIELD_ADS_TITLE]) : "";
	$adsContent = isset($_POST[FORM_FIELD_ADS_CONTENT])
		? trim($_POST[FORM_FIELD_ADS_CONTENT]) : "";
	$PAGE['form']['valueCategory'] = $categoryId;
	$PAGE['form']['valueAdsTitle'] = $adsTitle;
	$PAGE['form']['valueAdsContent'] = $adsContent;
	$cat = getCategory($categoryId);
	if ( $cat == NULL || $cat->getParentId()==0 ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_INVALID_CATEGORY_SELECTION'];
	} elseif ( $adsTitle == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_TITLE'];
	} elseif ( $adsContent == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_CONTENT'];
	} else {
		$expiry = 7*24*3600; //expires in 7 days!
		createEntry($cat, $CURRENT_USER, $expiry, $adsTitle, $adsContent);
	}
	
	/*
	if ( !$CURRENT_USER->authenticate($currentPwd) ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_PASSWORD_NOT_MATCH'];
	} elseif ( $newFullName == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_NEW_FULL_NAME'];
	} else {
		$CURRENT_USER->setFullName($newFullName);
		$PAGE['form']['informationMessage'] = $LANG['INFO_FULL_NAME_CHANGED'];
		updateUser($CURRENT_USER);
	}
*/
}

require_once 'templates/'.TEMPLATE.'/myprofile/pagePostAds.php';
?>
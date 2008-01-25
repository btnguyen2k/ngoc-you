<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/utils.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_HTML", "html");
define("FORM_FIELD_CATEGORY", "category");
define("FORM_FIELD_ADS_ID", "adsId");
define("FORM_FIELD_ADS_TITLE", "adsTitle");
define("FORM_FIELD_ADS_CONTENT", "adsContent");

$id = 0;
if ( isset($_POST[FORM_FIELD_ADS_ID]) ) {
	$id = $_POST[FORM_FIELD_ADS_ID] + 0;
} elseif ( isset($_GET[GET_PARAM_ID]) ) {
	$id = $_GET[GET_PARAM_ID] + 0;
}
$ads = getEntry($id);
if ( $ads!=NULL && $ads->getUserId()!=$CURRENT_USER->getId() ) $ads = NULL;

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - My Profile/Edit My Ads';
$PAGE['categoryTree'] = getCategoryTree();
$PAGE['ads'] = $ads;
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_EDIT_MY_ADS;
$PAGE['form']['fieldCategory'] = FORM_FIELD_CATEGORY;
$PAGE['form']['fieldAdsId'] = FORM_FIELD_ADS_ID;
$PAGE['form']['fieldAdsTitle'] = FORM_FIELD_ADS_TITLE;
$PAGE['form']['fieldAdsContent'] = FORM_FIELD_ADS_CONTENT;
$PAGE['form']['valueAdsId'] = $id;
$PAGE['form']['valueCategory'] = $ads!=NULL ? $ads->getCategoryId() : 0;
$PAGE['form']['valueAdsTitle'] = $ads!=NULL ? $ads->getTitle() : '';
$PAGE['form']['valueAdsContent'] = $ads!=NULL ? $ads->getContent() : '';
$PAGE['form']['errorMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$categoryId = isset($_POST[FORM_FIELD_CATEGORY])
		? $_POST[FORM_FIELD_CATEGORY]+0 : 0;
	$adsTitle = isset($_POST[FORM_FIELD_ADS_TITLE])
		? trim($_POST[FORM_FIELD_ADS_TITLE]) : "";
	$adsContent = isset($_POST[FORM_FIELD_ADS_CONTENT])
		? trim($_POST[FORM_FIELD_ADS_CONTENT]) : "";
	$html = isset($_POST[FORM_FIELD_HTML])
		? $_POST[FORM_FIELD_HTML]+0 : 0;		
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
		if ( $html == 0 ) {
			$adsContent = str_replace("\n", "<br>", $adsContent);
		}
		$ads->setCategoryId($categoryId);
		$ads->setTitle($adsTitle);
		$ads->setContent(removeEvilHtmlTags($adsContent));
		updateEntry($ads);
		header('Location: myprofile.php?'.GET_PARAM_ACTION.'='.ACTION_MY_ADS);
		return;
	}
}

require_once 'templates/'.TEMPLATE.'/myprofile/pageEditMyAds.php';
?>
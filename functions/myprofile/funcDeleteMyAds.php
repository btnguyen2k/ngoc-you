<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_ADS_ID", "adsId");

$id = 0;
if ( isset($_POST[FORM_FIELD_ADS_ID]) ) {
	$id = $_POST[FORM_FIELD_ADS_ID] + 0;
} elseif ( isset($_GET[GET_PARAM_ID]) ) {
	$id = $_GET[GET_PARAM_ID] + 0;
}
$ads = getEntry($id);
if ( $ads!==NULL && $ads->getUserId()!==$CURRENT_USER->getId() ) $ads = NULL;

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - My Profile/Delete My Ads';
$PAGE['categoryTree'] = getCategoryTree();
$PAGE['ads'] = $ads;
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_DELETE_MY_ADS;
$PAGE['form']['fieldAdsId'] = FORM_FIELD_ADS_ID;
$PAGE['form']['valueAdsId'] = $id;

if ( $ads !== NULL && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	deleteEntry($ads->getId());
	header('Location: myprofile.php?'.GET_PARAM_ACTION.'='.ACTION_MY_ADS);
	return;	
}

require_once 'templates/'.TEMPLATE.'/myprofile/pageDeleteMyAds.php';
?>
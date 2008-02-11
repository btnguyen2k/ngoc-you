<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

if ( $CURRENT_USER == NULL ) {
    header("Location: index.php?".GET_PARAM_ACTION."=".ACTION_LOGIN);
    return;
}

define("FORM_FIELD_ADS_ID", "adsId");

$id = 0;
if ( isset($_POST[FORM_FIELD_ADS_ID]) ) {
	$id = $_POST[FORM_FIELD_ADS_ID] + 0;
} elseif ( isset($_GET[GET_PARAM_ADS]) ) {
	$id = $_GET[GET_PARAM_ADS] + 0;
}
$ads = getEntry($id);
if ( $ads != NULL && $ads->isExpired() ) $ads = NULL;
$cat = $ads!=NULL ? getCategory($ads->getCategoryId()) : NULL;

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - '.($ads!=NULL?htmlspecialchars($ads->getTitle()):"");
$PAGE['category'] = $cat;
$PAGE['ads'] = $ads;
if ( $ads != NULL ) {
	increaseEntryNumViews($ads);
}

require_once 'templates/'.TEMPLATE.'/pageContactPoster.php';
?>
<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_ID]) ? $_GET[GET_PARAM_ID]+0 : 0;
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

require_once 'templates/'.TEMPLATE.'/pageViewAds.php';
?>
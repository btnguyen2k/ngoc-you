<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_ADS]) ? $_GET[GET_PARAM_ADS] + 0 : 0;
$ads = getEntry($id);
if ( $ads != NULL && $ads->isExpired() ) $ads = NULL;
if ( $ads == NULL ) {
    header("Location: index.php");
    return;
}
if ( $CURRENT_USER == NULL ) {
    $url = 'index.php?'.GET_PARAM_ACTION."=".ACTION_VIEW_ADS
        .'&'.GET_PARAM_ID.'='.$ads->getId();
    header("Location: $url");
    return;
}
$cat = $ads!=NULL ? getCategory($ads->getCategoryId()) : NULL;

define("FORM_FIELD_ADS_ID", "adsId");
define("FORM_FIELD_NAME", "name");
define("FORM_FIELD_EMAIL", "email");
define("FORM_FIELD_CONTENT", "content");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - '.($ads!=NULL?htmlspecialchars($ads->getTitle()):"");
$PAGE['ads'] = $ads;
$PAGE['category'] = $cat;

require_once 'templates/'.TEMPLATE.'/pageContactPosterDone.php';
?>
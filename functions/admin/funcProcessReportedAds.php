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
if ( $ads !== NULL && $ads->isExpired() ) $ads = NULL;
$cat = $ads!==NULL ? getCategory($ads->getCategoryId()) : NULL;

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Process Reported Ads';
$PAGE['content'] = Array();
$PAGE['content']['reportedAds'] = getAllReportedEntries();

require_once 'templates/'.TEMPLATE.'/admin/pageProcessReportedAds.php';
?>
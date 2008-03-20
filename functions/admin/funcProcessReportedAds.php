<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_PROCESS_ACTION", "processAction");

$id = isset($_GET[GET_PARAM_ID]) ? $_GET[GET_PARAM_ID] + 0 : 0;
$ads = getReportedEntry($id);
$cat = $ads!==NULL ? $ads->getentry()->getCategory() : NULL;

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Process Reported Ads';
$PAGE['reportedAds'] = $ads;
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['REQUEST_URI'];
$PAGE['form']['fieldProcessAction'] = FORM_FIELD_PROCESS_ACTION;

define('PROCESS_REPORTED_ADS_DELETE', 1);
define('PROCESS_REPORTED_ADS_UNREPORT', 2);

if ( $ads !== NULL && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $processAction = isset($_POST[FORM_FIELD_PROCESS_ACTION])
    ? $_POST[FORM_FIELD_PROCESS_ACTION]+0 : 0;
    switch ( $processAction ) {
        case PROCESS_REPORTED_ADS_DELETE:
            deleteEntry($ads->getId());
            break;
        case PROCESS_REPORTED_ADS_UNREPORT:
            unreportEntry($ads->getId());
            break;
    }
    $url = 'admin.php?'.GET_PARAM_ACTION.'='.ACTION_VIEW_REPORTED_ADS;
    header('Location: '.$url);
    return;
}
require_once 'templates/'.TEMPLATE.'/admin/pageProcessReportedAds.php';
?>
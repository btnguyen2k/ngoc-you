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
$PAGE['form']['action'] = 'admin.php?'.GET_PARAM_ACTION.'='.ACTION_EDIT_CAT;
$PAGE['form']['fieldProcessAction'] = FORM_FIELD_PROCESS_ACTION;

require_once 'templates/'.TEMPLATE.'/admin/pageProcessReportedAds.php';
?>
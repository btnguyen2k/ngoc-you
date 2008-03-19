<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Reported Ads';

$PAGE['content'] = Array();
$PAGE['content']['reportedAds'] = getAllReportedEntries();

require_once 'templates/'.TEMPLATE.'/admin/pageViewReportedAds.php';
?>
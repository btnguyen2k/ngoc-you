<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

require_once 'adminCommons.php';
adminCheckPermission(PERM_ACCESS_ADMIN_CP);

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Reported Ads';

$PAGE['content'] = Array();
$PAGE['content']['numCategories'] = countCategories();
$PAGE['content']['numAds'] = countEntries();
$PAGE['content']['numExpiredAds'] = countExpiredEntries();
$PAGE['content']['numReportedAds'] = countReportedEntries();
$PAGE['content']['numUsers'] = countUsers();

require_once 'templates/'.TEMPLATE.'/admin/pageIndex.php';
?>
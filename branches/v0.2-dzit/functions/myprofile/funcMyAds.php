<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - MyProfile/My Ads';
$PAGE['myAds'] = getEntriesForUser($CURRENT_USER->getId());

require_once 'templates/'.TEMPLATE.'/myprofile/pageMyAds.php';
?>
<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_CATEGORY]) ? $_GET[GET_PARAM_CATEGORY]+0 : 0;
$cat = getCategory($id);

$PAGE = Array();
if ( $cat != NULL ) {
    $PAGE['rss'] = 'index.php?'.GET_PARAM_ACTION.'='.ACTION_RSS_CAT;
    $PAGE['rss'] .= '&'.GET_PARAM_CATEGORY.'='.$cat->getId();
}
$PAGE['pageTitle'] = APPLICATION_NAME.' - '.($cat!=NULL?htmlspecialchars($cat->getName()):"");
$PAGE['category'] = $cat;
$PAGE['entries'] = $cat!=NULL?getEntriesForCategory($cat->getId()):Array();

require_once 'templates/'.TEMPLATE.'/pageViewCat.php';
?>
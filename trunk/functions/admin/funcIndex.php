<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Index';

$PAGE['content'] = Array();
$PAGE['content']['numCategories'] = countCategories();
$PAGE['content']['numEntries'] = countEntries();
$PAGE['content']['numUsers'] = countUsers();

require_once 'templates/'.TEMPLATE.'/admin/pageIndex.php';
?>
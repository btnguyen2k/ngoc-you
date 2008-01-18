<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Index';

$PAGE['content'] = Array();
$PAGE['categoryTree'] = getCategoryTree();

require_once 'templates/'.TEMPLATE.'/pageIndex.php';
?>
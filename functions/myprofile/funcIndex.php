<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - MyProfile/Index';

$PAGE['content'] = Array();

require_once 'templates/'.TEMPLATE.'/myprofile/pageIndex.php';
?>
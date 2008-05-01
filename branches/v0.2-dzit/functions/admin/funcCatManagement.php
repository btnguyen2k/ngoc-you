<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/authRules.php';
require_once 'dao/dbUtils.php';

require_once 'adminCommons.php';
adminCheckPermission(PERM_MANAGE_CATEGORY);

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Admin/Category Management';
$PAGE['categoryTree'] = getCategoryTree();

require_once 'templates/'.TEMPLATE.'/admin/pageCatManagement.php';
?>
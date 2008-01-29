<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includeUtils.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Traditional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?= $PAGE['pageTitle'] ?></title>
<?php
$_styles = Array('butter', 'chocolate', 'orange');
?>
<link href="<?= 'templates/'.TEMPLATE.'/' ?>style_butter.css.php" type="text/css" rel="stylesheet">
<?php
$_URI_HOME = dirname($_SERVER['PHP_SELF']);
$_URI_TEMPLATE = $_URI_HOME.'/templates/'.TEMPLATE; 
?>
</head>
<body>
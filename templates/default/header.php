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
<link href="<?='templates/'.TEMPLATE.'/'?>style_butter.css.php" type="text/css" rel="stylesheet">
<?php
if ( isset($PAGE['rss']) ) {
    echo '<link rel="alternate" type="application/rss+xml" title="RSS" href="', $PAGE['rss'], '">';
}
?>

<?php
$_URI_HOME = dirname($_SERVER['PHP_SELF']);
$_URI_TEMPLATE = $_URI_HOME.'/templates/'.TEMPLATE;
$_URI_TEMPLATE = preg_replace('/^\/+/', '/', $_URI_TEMPLATE);
?>
</head>
<body>
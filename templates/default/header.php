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
if ( isset($PAGE['pageKeywords']) ) {
    echo '<meta name="Keywords" content="'.htmlspecialchars($PAGE['pageKeywords']).'">';
    echo "\n";
}
if ( isset($PAGE['pageDescription']) ) {
    echo '<meta name="Description" content="'.htmlspecialchars($PAGE['pageDescription']).'">';
    echo "\n";
}
?>
<?php
$_styles = Array('butter', 'chocolate', 'orange');
?>
<link href="<?='templates/'.TEMPLATE.'/'?>style_butter.css.php" type="text/css" rel="stylesheet">
<?php
if ( isset($PAGE['rss']) ) {
    echo '<link rel="alternate" type="application/rss+xml" title="RSS" href="', $PAGE['rss'], '">';
}
?>
<style type="text/css">
table.ncode_imageresizer_warning {
	background: #FFFFE1;
	color: #000000;
	border: 1px solid #CCC;
	cursor: pointer;
}
table.ncode_imageresizer_warning td {
	font-size: 10px;
	vertical-align: middle;
	text-decoration: none;
}
/*
table.ncode_imageresizer_warning td.td1 {
	padding: 2px;
}
table.ncode_imageresizer_warning td.td2 {
	padding: 2px;
}
*/
</style>
<script type="text/javascript"src="<?='templates/'.TEMPLATE.'/'?>js/ncode_imageresizer.js"></script>
<script type="text/javascript">
NcodeImageResizer.TEMPLATE_PATH = '<?='templates/'.TEMPLATE?>';
NcodeImageResizer.MODE = 'enlarge';
NcodeImageResizer.MAXWIDTH = 640;
NcodeImageResizer.MAXHEIGHT = 0;
NcodeText = new Array();
NcodeText['ncode_imageresizer_warning_small'] = '<?= $LANG['ncode_imageresizer_warning_small'] ?>';
NcodeText['ncode_imageresizer_warning_filesize'] = '<?= $LANG['ncode_imageresizer_warning_filesize'] ?>';
NcodeText['ncode_imageresizer_warning_no_filesize'] = '<?= $LANG['ncode_imageresizer_warning_no_filesize'] ?>';
NcodeText['ncode_imageresizer_warning_fullsize'] = '<?= $LANG['ncode_imageresizer_warning_fullsize'] ?>';

function autoResizeLargeImgs() {
	var i;
	var n;
	var str;
	for ( i = 0, n = document.images.length; i < n; i++ ) {
		var img;
		img = document.images[i];
		if ( img.width > 320 ) {
			NcodeImageResizer.createOn(img);
		}
	} 
}
</script>
<?php
$_URI_HOME = dirname($_SERVER['PHP_SELF']);
$_URI_TEMPLATE = $_URI_HOME.'/templates/'.TEMPLATE;
$_URI_TEMPLATE = preg_replace('/^\/+/', '/', $_URI_TEMPLATE);
?>
</head>
<body onload="autoResizeLargeImgs();">
<?php
define("NGOC.YOU", 1);
require_once 'includes/includeSetup.php';
require_once 'includes/config.php';

define("GET_PARAM_ACTION", 'act');
define("DEFAULT_ACTION", 'index');

$ACTION = isset($_GET[GET_PARAM_ACTION])?$_GET[GET_PARAM_ACTION]:DEFAULT_ACTION;
$ACTION = strtolower(trim($ACTION));

if ( $ACTION == DEFAULT_ACTION ) {
	require_once 'functions/funcIndex.php';	
}
?>
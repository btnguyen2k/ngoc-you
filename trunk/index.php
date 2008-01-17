<?php
session_start();
define("NGOC.YOU", 1);
require_once 'includes/includeSetup.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';
require_once 'languages/lang_'.LANGUAGE.'.php';

define("DEFAULT_ACTION", 'index');

$ACTION = isset($_GET[GET_PARAM_ACTION])?$_GET[GET_PARAM_ACTION]:DEFAULT_ACTION;
$ACTION = strtolower(trim($ACTION));

if ( $ACTION == DEFAULT_ACTION ) {
	require_once 'functions/funcIndex.php';	
}
?>
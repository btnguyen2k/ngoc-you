<?php
require_once 'denyDirectInclude.php';

$_CACHE = Array();

function cacheGetEntry($name) {
	global $_CACHE;
	return isset($_CACHE[$name]) ? $_CACHE[$name] : NULL; 
}

function cacheSetEntry($name, $item) {
	global $_CACHE;
	$_CACHE[$name] = $item; 
}

function cacheRemoveEntry($name) {
	global $_CACHE;
	unset($_CACHE[$name]);
}
?>
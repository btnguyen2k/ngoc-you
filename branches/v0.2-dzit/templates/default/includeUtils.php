<?php
require_once 'includes/denyDirectInclude.php';
function __createCatUrlDelete($cat) {
	$url = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_DELETE_CAT;
	$url .= '&'.GET_PARAM_CATEGORY.'='.$cat->getId();
	return $url;
}

function __createCatUrlEdit($cat) {
	$url = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_EDIT_CAT;
	$url .= '&'.GET_PARAM_CATEGORY.'='.$cat->getId();
	return $url;
}

function __createCatUrlMoveDown($cat) {
	$url = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_MOVE_DOWN_CAT;
	$url .= '&'.GET_PARAM_CATEGORY.'='.$cat->getId();
	return $url;
}

function __createCatUrlMoveUp($cat) {
	$url = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_MOVE_UP_CAT;
	$url .= '&'.GET_PARAM_CATEGORY.'='.$cat->getId();
	return $url;
}
?>
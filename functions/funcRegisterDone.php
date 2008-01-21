<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_ID]) ? $_GET[GET_PARAM_ID]+0 : 0;
$user = getUser($id);

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Register'; 
$PAGE['user'] = $user;

require_once 'templates/'.TEMPLATE.'/pageRegisterDone.php';
?>
<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_CATEGORY]) ? $_GET[GET_PARAM_CATEGORY]+0 : 0;
$cat = getCategory($id);
if ( $cat !== NULL && $CURRENT_USER !== NULL ) {
    unwatchCategory($CURRENT_USER, $cat);
}

$url = isset($_SESSION[SESSION_LAST_ACCESS_PAGE]) ? $_SESSION[SESSION_LAST_ACCESS_PAGE] : NULL;
if ( $url === NULL ) {
    $url = 'index.php?'.GET_PARAM_ACTION.'='.ACTION_VIEW_CAT.'&cat='.$id;
}
header('Location: '.$url);
?>
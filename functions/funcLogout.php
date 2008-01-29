<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
unset($_SESSION[SESSION_CURRENT_USER_ID]);
$url = isset($_SESSION[SESSION_LAST_ACCESS_PAGE]) ? $_SESSION[SESSION_LAST_ACCESS_PAGE] : 'index.php';
header('Location: '.$url);
?>
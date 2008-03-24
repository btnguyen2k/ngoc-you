<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/authRules.php';

function adminCheckPermission($permission) {
    if ( authCheckPermission($permission) ) {
        return true;
    }
    header("HTTP/1.1 403 Access Denied!");
    exit(-1);
}
?>
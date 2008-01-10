<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
unset($_SESSION[SESSION_CURRENT_USER_ID]);
header('Location: admin.php');
?>
<?php
include_once 'denyDirectInclude.php';
define("AUTH_ACTIONS", Array());
define("AUTH_PERMISSIONS", Array(
	GROUP_ADMINISTRATOR => AUTH_ACTIONS, //admin can perform any action!
));
?>
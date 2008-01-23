<?php
require_once 'denyDirectInclude.php';

define("DEBUG_MODE", true);

define("DB_TYPE", "mysql");
define("DB_SERVER", "localhost");
define("DB_PORT", 3306); //default port for mysql is 3306
define("DB_USER", "ngocyou");
define("DB_PASSWORD", "ngocyou");
define("DB_SCHEMA", "ngocyou");

define("TEMPLATE", "default");
define("LANGUAGE", "en");

define("APPLICATION_NAME", "NgocYou");

$phpVersion = phpversion();
define("PHP_MAJOR_VERSION", intval($phpVersion));

define("SESSION_CURRENT_USER_ID", "CURRENT_USER_ID");

define("GET_PARAM_ACTION", 'act');
define("GET_PARAM_CATEGORY", 'cat');
define("GET_PARAM_ID", 'id');

define("GROUP_ADMINISTRATOR", 1);
define("GROUP_MODERATOR", 2);
define("GROUP_MEMBER", 3);

?>
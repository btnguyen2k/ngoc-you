<?php
require_once 'denyDirectInclude.php';

define("DEBUG_MODE", true);

define("DB_TYPE", "mysql");
define("DB_SERVER", "localhost");
define("DB_PORT", 3306); //default port for mysql is 3306
define("DB_USER", "ngocyou");
define("DB_PASSWORD", "ngocyou");
define("DB_SCHEMA", "ngocyou");
$DB_SETUP_SQLS = Array("SET NAMES 'utf8'");

define("TEMPLATE", "default");
define("LANGUAGE", "en");

if ( strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ) {
    //MSIE seems to have problem with xinha (or the other way?)
    define("WYSIWYG", "fckeditor");
} else {
    define("WYSIWYG", "xinha");
}

define("APPLICATION_NAME", "NgocYou");

define("DATE_FORMAT", "d-m-Y");
define("DATETIME_FORMAT", "g:ia d-m-Y");

$phpVersion = phpversion();
define("PHP_MAJOR_VERSION", intval($phpVersion));

define("SESSION_CURRENT_USER_ID", "CURRENT_USER_ID");
define("SESSION_LAST_ACCESS_PAGE", "LAST_ACCESS_PAGE");

define("GET_PARAM_ACTION", 'act');
define("GET_PARAM_CATEGORY", 'cat');
define("GET_PARAM_ADS", 'ads');
define("GET_PARAM_ID", 'id');

define("GROUP_ADMINISTRATOR", 1);
define("GROUP_MODERATOR", 2);
define("GROUP_MEMBER", 3);

?>
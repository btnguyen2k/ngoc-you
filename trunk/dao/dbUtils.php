<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';

define("TABLE_USER", "nyuser");
define("TABLE_GROUP", "nygroup");
define("TABLE_CATEGORY", "nycategory");
define("TABLE_ENTRY", "nyentry");

$DBACCESS = null;

if ( strtoupper(DB_TYPE) == "MYSQL" ) {
	require_once 'php4/ClassDbAccessMySQL.php';
	$DBACCESS = new DbAccessMySQL();
} else {
	die("Database type is not supported!");
}

function getDbConn() {
	global $DBACCESS; 
	return $DBACCESS->getDbConn();	
}

/* Category and entry-related functions */
function getAllCategories() {
	global $DBACCESS; 
	return $DBACCESS->getAllCategories($id);
}

function countCategories() {
	global $DBACCESS; 
	return $DBACCESS->countCategories();
}

function countEntries() {
	global $DBACCESS; 
	return $DBACCESS->countEntries();
}

function getCategory($id) {
	global $DBACCESS; 
	return $DBACCESS->getCategory($id);
}
/* Category and entry-related functions */

/* User account-related functions */
function countUsers() {
	global $DBACCESS; 
	return $DBACCESS->countUsers();
}

function getUser($id) {
	global $DBACCESS; 
	return $DBACCESS->getUser($id);
}

function getUserByEmail($email) {
	global $DBACCESS; 
	return $DBACCESS->getUserByEmail($email);
}

function getUserByLoginName($loginName) {
	global $DBACCESS; 
	return $DBACCESS->getUserByLoginName($loginName);
}
/* User account-related functions */
?>
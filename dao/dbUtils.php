<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';

define("TABLE_USER", "nyuser");

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

function getAllCategories() {
	global $DBACCESS; 
	return $DBACCESS->getAllCategories($id);
}

function getCategory($id) {
	global $DBACCESS; 
	return $DBACCESS->getCategory($id);
}

/* User account-related functions */
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
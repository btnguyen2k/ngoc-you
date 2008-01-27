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
function countCategories() {
	global $DBACCESS; 
	return $DBACCESS->countCategories();
}

function countEntries() {
	global $DBACCESS; 
	return $DBACCESS->countEntries();
}

function createCategory($name, $desc, $parent=NULL) {
	global $DBACCESS; 
	return $DBACCESS->createCategory($name, $desc, $parent);
}

function createEntry($cat, $user, $expiry, $title, $content) {
	global $DBACCESS; 
	return $DBACCESS->createEntry($cat, $user, $expiry, $title, $content);
}

function deleteCategory($id) {
	global $DBACCESS; 
	$DBACCESS->deleteCategory($id);
}

function deleteEntry($id) {
	global $DBACCESS; 
	$DBACCESS->deleteEntry($id);
}

function getCategory($id) {
	global $DBACCESS; 
	return $DBACCESS->getCategory($id);
}

function getCategoryTree() {
	global $DBACCESS; 
	return $DBACCESS->getCategoryTree();
}

function getEntriesForCategory($catId) {
	global $DBACCESS; 
	return $DBACCESS->getEntriesForCategory($catId);
}

function getEntriesForUser($userId) {
	global $DBACCESS; 
	return $DBACCESS->getEntriesForUser($userId);
}

function getEntry($id) {
	global $DBACCESS; 
	return $DBACCESS->getEntry($id);
}

function updateCategory($cat) {
	global $DBACCESS; 
	$DBACCESS->updateCategory($cat);
}

function updateEntry($entry) {
	global $DBACCESS; 
	$DBACCESS->updateEntry($entry);
}
/* Category and entry-related functions */

/* User account-related functions */
function countUsers() {
	global $DBACCESS; 
	return $DBACCESS->countUsers();
}

function createUser($loginName, $password, $email, $fullName) {
	global $DBACCESS; 
	return $DBACCESS->createUser($loginName, $password, $email, $fullName);
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

function updateUser($user) {
	global $DBACCESS; 
	$DBACCESS->updateUser($user);
}
/* User account-related functions */
?>
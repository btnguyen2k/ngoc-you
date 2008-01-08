<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'ClassDbAccess.php';

require_once 'ClassUser.php';

class DbAccessMySQL extends DbAccess {
	function createDbConn() {
		$dbServer = DB_SERVER.":".DB_PORT;
		$conn = mysql_connect($dbServer, DB_USER, DB_PASSWORD);
		if ( defined("DB_SCHEMA") ) {
			mysql_select_db(DB_SCHEMA, $conn);
		}
		return $conn;
	}
	
	/* Category and Entry-related functions */
	function countCategories() {
		$conn = getDbConn();
		$sql = "SELECT COUNT(*) FROM ".TABLE_CATEGORY;
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		if ( $row = mysql_fetch_row($resultSet) ) {
			$result = $row[0];
			mysql_free_result($resultSet);
			return $result;
		} else {
			return 0;
		}
	}
	
	function countEntries() {
		$conn = getDbConn();
		$sql = "SELECT COUNT(*) FROM ".TABLE_ENTRY;
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		if ( $row = mysql_fetch_row($resultSet) ) {
			$result = $row[0];
			mysql_free_result($resultSet);
			return $result;
		} else {
			return 0;
		}
	}
	
	function getAllCategories() {
		$conn = getDbConn();
		$result = Array();
		return $result;
	}
	/* Category and Entry-related functions */
	
	/* User and Group-related functions */
	function countUsers() {
		$conn = getDbConn();
		$sql = "SELECT COUNT(*) FROM ".TABLE_USER;
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		if ( $row = mysql_fetch_row($resultSet) ) {
			$result = $row[0];
			mysql_free_result($resultSet);
			return $result;
		} else {
			return 0;
		}
	}
	
	function getUserByLoginName($loginName) {
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_USER." WHERE uloginname='{loginName}'";
		$sql = str_replace('{loginName}', mysql_real_escape_string($loginName, $conn), $sql);					
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		if ( $row = mysql_fetch_assoc($resultSet) ) {
			$user = new User();
			$user->populate($row);			
			mysql_free_result($resultSet);
			return $user;
		} else {
			return NULL;
		}
	}
	/* User and Group-related functions */
}
?>
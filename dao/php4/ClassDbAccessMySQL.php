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
}
?>
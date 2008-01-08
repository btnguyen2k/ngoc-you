<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'ClassDbAccess.php';

require_once 'ClassUser.php';
require_once 'ClassCategory.php';

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
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		$result = 0;
		if ( $row = mysql_fetch_row($resultSet) ) {
			$result = $row[0];			
		}
		mysql_free_result($resultSet);
		return $result;
	}
	
	function countEntries() {
		$conn = getDbConn();
		$sql = "SELECT COUNT(*) FROM ".TABLE_ENTRY;
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		$result = 0;
		if ( $row = mysql_fetch_row($resultSet) ) {
			$result = $row[0];			
		}
		mysql_free_result($resultSet);
		return $result;
	}
	
	function getAllCategories() {
		$conn = getDbConn();
		$result = Array();
		$catsMap = Array();
		$sql = "SELECT * FROM ".TABLE_CATEGORY." ORDER BY cparentid, cposition DESC";
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		while ( $row = mysql_fetch_assoc($resultSet) ) {
			$cat = new Category();
			$cat->populate($row);
			$id = $cat->getId();
			$parentId = $cat->getParentId();
			$catsMap[$id] = $cat;
			if ( isset($catsMap[$parentId]) ) {
				$catsMap[$parentId]->addChild($cat);
			}			
			if ( $parentId < 1 ) {
				$result[] = $cat;
			}
		}
		mysql_free_result($resultSet);
		return $result;
	}
	
	function getCategory($id) {
		$id+=0;
		if ( $id < 1 ) return NULL;
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_CATEGORY." WHERE cid={catId}";
		$sql = str_replace('{catId}', $id);
		$this->logSql($sql);					
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		$cat = NULL;
		if ( $row = mysql_fetch_assoc($resultSet) ) {
			$cat = new Category();
			$cat->populate($row);						
		}
		mysql_free_result($resultSet);
		return $cat;
	}
	/* Category and Entry-related functions */
	
	/* User and Group-related functions */
	function countUsers() {
		$conn = getDbConn();
		$sql = "SELECT COUNT(*) FROM ".TABLE_USER;
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		$result = 0;
		if ( $row = mysql_fetch_row($resultSet) ) {
			$result = $row[0];			
		}
		mysql_free_result($resultSet);
		return $result;
	}
	
	function getUserByLoginName($loginName) {
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_USER." WHERE uloginname='{loginName}'";
		$sql = str_replace('{loginName}', mysql_real_escape_string($loginName, $conn), $sql);
		$this->logSql($sql);					
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('Invalid query: ' . mysql_error());
		}
		$user = NULL;
		if ( $row = mysql_fetch_assoc($resultSet) ) {
			$user = new User();
			$user->populate($row);						
		}
		mysql_free_result($resultSet);
		return $user;
	}
	/* User and Group-related functions */
}
?>
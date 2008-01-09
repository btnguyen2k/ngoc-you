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
			die('['.get_class($this).'.countCategories()] Invalid query: ' . mysql_error());
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
			die('['.get_class($this).'.countEntries()] Invalid query: ' . mysql_error());
		}
		$result = 0;
		if ( $row = mysql_fetch_row($resultSet) ) {
			$result = $row[0];			
		}
		mysql_free_result($resultSet);
		return $result;
	}
	
	function createCategory($name, $desc, $parent=NULL) {
		$conn = getDbConn();
		$sql = "INSERT INTO ".TABLE_CATEGORY
			." (cname, cdesc, cposition, cparentid) VALUES ("
			."'{catName}', '{catDescription}', {catPosition}, {parentId})";
		$sql = str_replace('{catName}', mysql_real_escape_string($name, $conn), $sql);
		$sql = str_replace('{catDescription}', mysql_real_escape_string($desc, $conn), $sql);
		if ( $parent != NULL ) {
			$sql = str_replace('{catPosition}', $parent->getNumChildren(), $sql);
			$sql = str_replace('{parentId}', $parent->getId(), $sql);
		} else {
			$pos = count($this->getAllCategories());
			$sql = str_replace('{catPosition}', $pos, $sql);
			$sql = str_replace('{parentId}', 'NULL', $sql);
		}
		$this->logSql($sql);
		if ( !mysql_query($sql, $conn) ) {
			die('['.get_class($this).'.createCategory()] Invalid query: ' . mysql_error());
		}
		$id = mysql_insert_id($conn);
		return $this->getCategory($id);
	}
	
	function getAllCategories() {
		$conn = getDbConn();
		$result = Array();
		$catsMap = Array();
		$sql = "SELECT * FROM ".TABLE_CATEGORY." ORDER BY cparentid, cposition DESC";
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.getAllCategories()] Invalid query: ' . mysql_error());
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
		$sql = str_replace('{catId}', $id, $sql);
		$this->logSql($sql);					
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.getCategory()] Invalid query: ' . mysql_error());
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
			die('['.get_class($this).'.countUsers()] Invalid query: ' . mysql_error());
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
			die('['.get_class($this).'.getUserByLoginName()] Invalid query: ' . mysql_error());
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
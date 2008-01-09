<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/inmemoryCaching.php';

require_once 'ClassDbAccess.php';

require_once 'ClassUser.php';
require_once 'ClassCategory.php';

define("CACHE_KEY_CATEGORIES_LIST", "CATEGORIES_LIST");
define("CACHE_KEY_CATEGORIES_MAP", "CATEGORIES_MAP");
define("CACHE_KEY_CATEGORIES_TREE", "CATEGORIES_TREE");

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
		$this->_renewCategoryCache();
		return $this->getCategory($id);
	}
	
	function getCategory($id) {
		$id+=0;
		$this->_loadCategories();
		$catsMap = cacheGetEntry(CACHE_KEY_CATEGORIES_MAP);
		return $catsMap != NULL && isset($catsMap[$id]) ? $catsMap[$id] : NULL;
	}
	
	function getCategoryTree() {
		$this->_loadCategories();
		$catsTree = cacheGetEntry(CACHE_KEY_CATEGORIES_TREE);
		return $catsTree != NULL ? $catsTree : Array();
	}
	
	function _loadCategories() {
		$catsList = cacheGetEntry(CACHE_KEY_CATEGORIES_LIST);
		if ( $catsList != NULL ) return;

		$conn = getDbConn();
		$catsList = Array();
		$catsMap = Array();
		$catsTree = Array();
		$sql = "SELECT * FROM ".TABLE_CATEGORY." ORDER BY cparentid, cposition DESC";
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'._loadCategories()] Invalid query: ' . mysql_error());
		}
		while ( $row = mysql_fetch_assoc($resultSet) ) {
			$cat = new Category();
			$cat->populate($row);
			$catsList[] = $cat;
			$id = $cat->getId();
			$parentId = $cat->getParentId();
			$catsMap[$id] = $cat;
			if ( isset($catsMap[$parentId]) ) {
				$catsMap[$parentId]->addChild($cat);
			}			
			if ( $parentId < 1 ) {
				$catsTree[] = $cat;
			}
		}
		mysql_free_result($resultSet);
		cacheSetEntry(CACHE_KEY_CATEGORIES_LIST, $catsList);
		cacheSetEntry(CACHE_KEY_CATEGORIES_MAP, $catsMap);
		cacheSetEntry(CACHE_KEY_CATEGORIES_TREE, $catsTree);
	}
	
	function _renewCategoryCache() {
		cacheRemoveEntry(CACHE_KEY_CATEGORIES_LIST);
		cacheRemoveEntry(CACHE_KEY_CATEGORIES_MAP);
		cacheRemoveEntry(CACHE_KEY_CATEGORIES_TREE);
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
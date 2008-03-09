<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/inmemoryCaching.php';

require_once 'ClassDbAccess.php';

require_once 'ClassUser.php';
require_once 'ClassCategory.php';
require_once 'ClassEntry.php';

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
		$sql = "SELECT COUNT(*) FROM ".TABLE_ENTRY
		    ." WHERE eexpirytimestamp > {expiryTimestamp}";
		$sql = str_replace('{expiryTimestamp}', time(), $sql); 
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
	
	function countEntriesForCategory($catId) {
		$conn = getDbConn();
		$sql = "SELECT COUNT(*) FROM ".TABLE_ENTRY
		    ." WHERE ecatid={catId} AND eexpirytimestamp>{expiryTimestamp}";
		$sql = str_replace('{catId}', $catId+0, $sql);
		$sql = str_replace('{expiryTimestamp}', time(), $sql);
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.countEntriesForCategory()] Invalid query: ' . mysql_error());
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
		if ( $parent !== NULL ) {
			$sql = str_replace('{catPosition}', $parent->getNumChildren()+1, $sql);
			$sql = str_replace('{parentId}', $parent->getId(), $sql);
		} else {
			$pos = count($this->getCategoryTree())+1;
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

	function createEntry($cat, $user, $expiry, $title, $content) {
		$conn = getDbConn();
		$sql = "INSERT INTO ".TABLE_ENTRY
		." (ecatid, euserid, ecreationtimestamp, eexpirytimestamp, etitle, ebody) VALUES ("
		."{catId}, {userId}, {creationTimestamp}, {expiryTimestamp}, '{title}', '{content}')";
		$current = time();
		$sql = str_replace('{catId}', $cat->getId(), $sql);
		$sql = str_replace('{userId}', $user->getId(), $sql);
		$sql = str_replace('{creationTimestamp}', $current, $sql);
		$sql = str_replace('{expiryTimestamp}', $current+$expiry, $sql);
		$sql = str_replace('{title}', mysql_real_escape_string($title, $conn), $sql);
		$sql = str_replace('{content}', mysql_real_escape_string($content, $conn), $sql);
		$this->logSql($sql);
		if ( !mysql_query($sql, $conn) ) {
			die('['.get_class($this).'.createEntry()] Invalid query: ' . mysql_error());
		}
		$id = mysql_insert_id($conn);
		$this->_renewCategoryCache();
		return $this->getEntry($id);
	}

	function deleteCategory($id) {
		$conn = getDbConn();
		$id+=0;
		$sql = "DELETE FROM ".TABLE_CATEGORY." WHERE cid={catId}";
		$sql = str_replace("{catId}", $id, $sql);
		$this->logSql($sql);
		if ( !mysql_query($sql, $conn) ) {
			die('['.get_class($this).'.deleteCategory()] Invalid query: ' . mysql_error());
		}
		$this->_renewCategoryCache();
	}

	function deleteEntry($id) {
		$conn = getDbConn();
		$id+=0;
		$sql = "DELETE FROM ".TABLE_ENTRY." WHERE eid={id}";
		$sql = str_replace("{id}", $id, $sql);
		$this->logSql($sql);
		if ( !mysql_query($sql, $conn) ) {
			die('['.get_class($this).'.deleteEntry()] Invalid query: ' . mysql_error());
		}
		$this->_renewCategoryCache();
	}

	function getCategory($id) {
		$id+=0;
		$this->_loadCategories();
		$catsMap = cacheGetEntry(CACHE_KEY_CATEGORIES_MAP);
		return $catsMap !== NULL && isset($catsMap[$id]) ? $catsMap[$id] : NULL;
	}

	function getCategoryTree() {
		$this->_loadCategories();
		$catsTree = cacheGetEntry(CACHE_KEY_CATEGORIES_TREE);
		return $catsTree !== NULL ? $catsTree : Array();
	}

	function getEntry($id) {
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_ENTRY." WHERE eid={id}";
		$sql = str_replace('{id}', $id+0, $sql);
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.getEntry()] Invalid query: ' . mysql_error());
		}
		$entry = NULL;
		if ( $row = mysql_fetch_assoc($resultSet) ) {
			$entry = new Entry();
			$entry->populate($row);
			$entry->setPoster($this->getUser($entry->getUserId()));
		}
		mysql_free_result($resultSet);		
		return $entry;
	}
	
	function increaseEntryNumViews($entry, $value=1) {
		$entry->setNumViews($entry->getNumViews() + $value);
		$this->updateEntry($entry);
	}

	function getEntriesForCategory($catId) {
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_ENTRY
		    ." WHERE ecatid={catId} AND eexpirytimestamp>{expiryTimestamp}"
		    ." ORDER BY eexpirytimestamp DESC";
		$sql = str_replace('{expiryTimestamp}', time(), $sql);
		$sql = str_replace('{catId}', $catId+0, $sql);
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.getEntriesForCategory()] Invalid query: ' . mysql_error());
		}
		$result = Array();
		while ( $row = mysql_fetch_assoc($resultSet) ) {
			$entry = new Entry();
			$entry->populate($row);
			$result[] = $entry;
		}
		mysql_free_result($resultSet);
		return $result;
	}
	
	function getEntriesForRss($catId=0) {
		$conn = getDbConn();
		//$sql = "SELECT * FROM ".TABLE_ENTRY." WHERE eexpirytimestamp > {rssTimestamp}";
		$sql = "SELECT * FROM ".TABLE_ENTRY
		    ." WHERE eexpirytimestamp>{expiryTimestamp}";
		$sql = str_replace('{expiryTimestamp}', time(), $sql);
		if ( $catId > 0 ) {
		    $sql .= " AND ecatid={catId}";		    		    
		}
		$sql .= " ORDER BY eexpirytimestamp DESC LIMIT 10";
		$rssTimestamp = time() + 6*24*3600;
		$sql = str_replace('{rssTimestamp}', $rssTimestamp, $sql);
		$sql = str_replace('{catId}', $catId+0, $sql);
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.getEntriesForRss()] Invalid query: ' . mysql_error());
		}
		$result = Array();
		while ( $row = mysql_fetch_assoc($resultSet) ) {
			$entry = new Entry();
			$entry->populate($row);
			$result[] = $entry;
		}
		mysql_free_result($resultSet);
		return $result;
	}
	
	function getEntriesForUser($userId) {
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_ENTRY
		    ." WHERE euserid={userId} AND eexpirytimestamp>{expiryTimestamp}"
		    ." ORDER BY ecreationtimestamp DESC";
		$sql = str_replace('{expiryTimestamp}', time(), $sql);
		$sql = str_replace('{userId}', $userId+0, $sql);
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.getEntriesForUser()] Invalid query: ' . mysql_error());
		}
		$result = Array();
		while ( $row = mysql_fetch_assoc($resultSet) ) {
			$entry = new Entry();
			$entry->populate($row);
			$result[] = $entry;
		}
		mysql_free_result($resultSet);
		return $result;
	}

	function updateCategory($cat) {
		$conn = getDbConn();
		$sql = "UPDATE ".TABLE_CATEGORY
		." SET cparentId={parentId}, cposition={catPosition}, cname='{catName}', cdesc='{catDescription}'"
		." WHERE cid={catId}";
		$sql = str_replace('{catId}', $cat->getId(), $sql);
		$sql = str_replace('{catName}',
		mysql_real_escape_string($cat->getName(), $conn), $sql);
		$sql = str_replace('{catDescription}',
		mysql_real_escape_string($cat->getDescription(), $conn), $sql);
		$sql = str_replace('{catPosition}', $cat->getPosition(), $sql);
		if ( $cat->getParentId() < 1 ) {
			$sql = str_replace('{parentId}', 'NULL', $sql);
		} else {
			$sql = str_replace('{parentId}', $cat->getParentId(), $sql);
		}
		$this->logSql($sql);
		if ( !mysql_query($sql, $conn) ) {
			die('['.get_class($this).'.updateCategory()] Invalid query: ' . mysql_error());
		}
		$this->_renewCategoryCache();
	}

	function updateEntry($entry) {
		$conn = getDbConn();
		$sql = "UPDATE ".TABLE_ENTRY
		." SET ecatId={catId}, eexpirytimestamp={expiryTimestamp}, etitle='{title}', ebody='{content}', enumviews={numViews}"
		." WHERE eid={id}";
		$sql = str_replace('{id}', $entry->getId(), $sql);
		$sql = str_replace('{catId}', $entry->getCategoryId(), $sql);
		$sql = str_replace('{expiryTimestamp}', $entry->getExpiryTimestamp(), $sql);
		$sql = str_replace('{title}', mysql_real_escape_string($entry->getTitle(), $conn), $sql);
		$sql = str_replace('{content}', mysql_real_escape_string($entry->getContent(), $conn), $sql);
		$sql = str_replace('{numViews}', $entry->getNumViews(), $sql);
		$this->logSql($sql);
		if ( !mysql_query($sql, $conn) ) {
			die('['.get_class($this).'.updateEntry()] Invalid query: ' . mysql_error());
		}
		$this->_renewCategoryCache();
	}

	function _loadCategories() {
		$catsList = cacheGetEntry(CACHE_KEY_CATEGORIES_LIST);
		if ( $catsList !== NULL ) return;

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
			$cat->setNumEntries($this->countEntriesForCategory($cat->getId()));
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

	function createUser($loginName, $password, $email, $fullName="", $groupId=GROUP_MEMBER) {
		$conn = getDbConn();
		$sql = "INSERT INTO ".TABLE_USER
		." (uloginname, upassword, uemail, ufullname, ucreationtimestamp, ugroupid)"
		." VALUES('{loginName}', '{password}', '{email}', '{fullName}', {creationTimestamp}, {groupId})";
		$loginName = strtolower(trim($loginName));
		$email = strtolower(trim($email));
		$password = md5(trim($password));
		$fullName = trim($fullName);
		$creationTimestamp = time();
		$groupId += 0;
		if ( $groupId !== GROUP_ADMINISTRATOR
		&& $groupId !== GROUP_MODERATOR
		&& $groupId !== GROUP_MEMBER ) {
			$groupId = GROUP_MEMBER;
		}
		$sql = str_replace('{loginName}', mysql_real_escape_string($loginName, $conn), $sql);
		$sql = str_replace('{password}', mysql_real_escape_string($password, $conn), $sql);
		$sql = str_replace('{email}', mysql_real_escape_string($email, $conn), $sql);
		$sql = str_replace('{fullName}', mysql_real_escape_string($fullName, $conn), $sql);
		$sql = str_replace('{creationTimestamp}', $creationTimestamp, $sql);
		$sql = str_replace('{groupId}', $groupId, $sql);
		$this->logSql($sql);
		mysql_query($sql, $conn);
		return $this->getUserByLoginName($loginName);
	}

	function getUser($id) {
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_USER." WHERE uid={userId}";
		$sql = str_replace('{userId}', $id+0, $sql);
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.getUser()] Invalid query: ' . mysql_error());
		}
		$user = NULL;
		if ( $row = mysql_fetch_assoc($resultSet) ) {
			$user = new User();
			$user->populate($row);
		}
		mysql_free_result($resultSet);
		return $user;
	}

	function getUserByEmail($email) {
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_USER." WHERE uemail='{email}'";
		$sql = str_replace('{email}',
		mysql_real_escape_string(strtolower($email), $conn), $sql);
		$this->logSql($sql);
		$resultSet = mysql_query($sql, $conn);
		if ( !$resultSet ) {
			die('['.get_class($this).'.getUserByEmail()] Invalid query: ' . mysql_error());
		}
		$user = NULL;
		if ( $row = mysql_fetch_assoc($resultSet) ) {
			$user = new User();
			$user->populate($row);
		}
		mysql_free_result($resultSet);
		return $user;
	}

	function getUserByLoginName($loginName) {
		$conn = getDbConn();
		$sql = "SELECT * FROM ".TABLE_USER." WHERE uloginname='{loginName}'";
		$sql = str_replace('{loginName}',
		mysql_real_escape_string(strtolower($loginName), $conn), $sql);
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

	function updateUser($user) {
		$conn = getDbConn();
		$sql = "UPDATE ".TABLE_USER
		." SET uloginname='{loginName}', upassword='{password}', uemail='{email}', ufullname='{fullName}'"
		." WHERE uid={userId}";
		$sql = str_replace('{loginName}',
		mysql_real_escape_string(strtolower($user->getLoginName()), $conn), $sql);
		$sql = str_replace('{password}',
		mysql_real_escape_string($user->getPassword(), $conn), $sql);
		$sql = str_replace('{email}',
		mysql_real_escape_string(strtolower($user->getEmail()), $conn), $sql);
		$sql = str_replace('{fullName}',
		mysql_real_escape_string($user->getFullName(), $conn), $sql);
		$sql = str_replace('{userId}', $user->getId(), $sql);
		$this->logSql($sql);
		if ( !mysql_query($sql, $conn) ) {
			die('['.get_class($this).'.updateUser()] Invalid query: ' . mysql_error());
		}
		$this->_renewCategoryCache();
	}
	/* User and Group-related functions */
}
?>
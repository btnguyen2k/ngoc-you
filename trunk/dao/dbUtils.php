<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';

require_once 'adodb.inc.php';

require_once 'ClassConfigDao.php';
require_once 'ClassCategoryDao.php';
require_once 'ClassEntryDao.php';
require_once 'ClassUserDao.php';

define("TABLE_CONFIG", "nyconfig");
define("TABLE_USER", "nyuser");
define("TABLE_GROUP", "nygroup");
define("TABLE_CATEGORY", "nycategory");
define("TABLE_ENTRY", "nyentry");

/**
 * @var ADOConnection
 */
$ADODB_CONN = NULL;

if ( DEBUG_MODE ) {
    $EXECS = 0;
    $CACHED = 0;
    $SQL_EXECS = Array();
    
    function &adodbCountExecs($db, $sql, $inputArray) {
        global $EXECS;
        global $SQL_EXECS;
        
        $SQL_EXECS[] = $sql;
    
        if ( !is_array($inputArray) ){
            $EXECS++;
        } else if ( is_array(reset($inputArray)) ) {
            // handle 2-dimensional input arrays
            $EXECS += sizeof($inputArray);
        } else {
            $EXECS++;
        }
        $null = NULL;
        return $null;
    }
    
    function adodbCountCachedExecs($db, $secs2cache, $sql, $inputArray) {
        global $CACHED;
        $CACHED++;
    }
}

function adodbGetConnection() {
    /**
     * @var ADOConnection
     */
    global $ADODB_CONN;
    if ( $ADODB_CONN == NULL ) {
        $dsn = DB_TYPE.'://'.DB_USER.':'.DB_PASSWORD.'@'.DB_SERVER.':'.DB_PORT.'/'.DB_SCHEMA;
        $ADODB_CONN = NewADOConnection($dsn);
        if ( $ADODB_CONN === false ) {
            die("Can not connect to database!");
        }
        register_shutdown_function('adodbCloseConnection');
        if ( DEBUG_MODE ) {
            $ADODB_CONN->fnExecute = 'adodbCountExecs';
            $ADODB_CONN->fnCacheExecute = 'adodbCountCachedExecs';
        }
        $ADODB_CONN->StartTrans();
    }
    return $ADODB_CONN;
}

function adodbCloseConnection() {
    /**
     * @var ADOConnection
     */
    global $ADODB_CONN;
    if ( $ADODB_CONN != NULL ) {
        $ADODB_CONN->CompleteTrans();
        $ADODB_CONN = NULL;
    }
}

//$DBACCESS = null;
//
//if ( strtoupper(DB_TYPE) == "MYSQL" ) {
//    require_once 'php4/ClassDbAccessMySQL.php';
//    $DBACCESS = new DbAccessMySQL();
//} else {
//    die("Database type is not supported!");
//}

function getDbConn() {
    global $DBACCESS;
    return $DBACCESS->getDbConn();
}

/* Category and entry-related functions */
function countCategories() {
    return CategoryDao::countCategories();
}

function countEntries() {
    return CategoryDao::countEntries();
}

function createCategory($name, $desc, $parent=NULL) {
    return CategoryDao::createCategory($name, $desc, $parent);
}

function createEntry($cat, $user, $expiry, $title, $content) {
    global $DBACCESS;
    return $DBACCESS->createEntry($cat, $user, $expiry, $title, $content);
}

function deleteCategory($id) {
    CategoryDao::deleteCategory($id);
}

function deleteEntry($id) {
    global $DBACCESS;
    $DBACCESS->deleteEntry($id);
}

function getCategory($id) {
    return CategoryDao::getCategory($id);
}

function getCategoryTree() {
    return CategoryDao::getCategoryTree();
}

function getEntriesForCategory($catId) {
    return EntryDao::getEntriesForCategory($catId);
}

function getEntriesForRss($catId=0) {
    global $DBACCESS;
    return $DBACCESS->getEntriesForRss($catId);
}

function getEntriesForUser($userId) {
    global $DBACCESS;
    return $DBACCESS->getEntriesForUser($userId);
}

function getEntry($id) {
    global $DBACCESS;
    return $DBACCESS->getEntry($id);
}

function increaseEntryNumViews($entry, $value=1) {
    global $DBACCESS;
    $DBACCESS->increaseEntryNumViews($entry, $value);
}

function updateCategory($cat) {
    CategoryDao::updateCategory($cat);
}

function updateEntry($entry) {
    global $DBACCESS;
    $DBACCESS->updateEntry($entry);
}
/* Category and entry-related functions */

/* User account-related functions */
function countUsers() {
    return UserDao::countUsers();
}

function createUser($loginName, $password, $email, $fullName) {
    global $DBACCESS;
    return $DBACCESS->createUser($loginName, $password, $email, $fullName);
}

function getUser($id) {
    return UserDao::getUser($id);
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
    UserDao::updateUser($user);
}
/* User account-related functions */
?>
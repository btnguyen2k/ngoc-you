<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';

require_once 'adodb.inc.php';

require_once 'ClassLocationDao.php';
require_once 'ClassConfigDao.php';
require_once 'ClassCategoryDao.php';
require_once 'ClassEntryDao.php';
require_once 'ClassUserDao.php';

define("TABLE_LOCATION", "nylocation");
define("TABLE_CONFIG", "nyconfig");
define("TABLE_USER", "nyuser");
define("TABLE_GROUP", "nygroup");
define("TABLE_CATEGORY", "nycategory");
define("TABLE_ENTRY", "nyentry");
define("TABLE_UPLOAD", "nyupload");

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
    global $DB_SETUP_SQLS;
    if ( $ADODB_CONN === NULL ) {
        $dsn = DB_TYPE.'://'.DB_USER.':'.DB_PASSWORD.'@'.DB_SERVER.':'.DB_PORT.'/'.DB_SCHEMA;
        $ADODB_CONN = NewADOConnection($dsn);
        if ( $ADODB_CONN === false ) {
            die("Can not connect to database!");
        }
        if ( isset($DB_SETUP_SQLS) ) {
            if ( is_array($DB_SETUP_SQLS) ) {
                foreach ( $DB_SETUP_SQLS as $sql ) {
                    $ADODB_CONN->Execute($sql);
                }
            } else{
                $ADODB_CONN->Execute($DB_SETUP_SQLS);
            }
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
    if ( $ADODB_CONN !== NULL ) {
        $ADODB_CONN->CompleteTrans();
        $ADODB_CONN = NULL;
    }
}

/* Location-related functions */
function getAllLocations() {
    return LocationDao::getAllLocations();
}
/* Location-related functions */

/* Configuration-related functions */
function getAllConfigs() {
    return ConfigDao::getAllConfigs();
}

function getConfig($key) {
    return ConfigDao::getConfig($key);
}

function updateConfig($key, $value) {
    return ConfigDao::updateConfig($key, $value);
}
/* Configuration-related functions */

/* Category and entry-related functions */
function addUploadFilesToEntry($entry, $uploadFiles=Array()) {
    EntryDao::addUploadFilesToEntry($entry, $uploadFiles);
}

function deleteAttachmentsFromEntry($entry, $attachmentList=Array()) {
    EntryDao::deleteAttachmentsFromEntry($entry, $attachmentList);
}

function countCategories() {
    return CategoryDao::countCategories();
}

function countExpiredEntries() {
    return CategoryDao::countExpiredEntries();
}

function countEntries() {
    return CategoryDao::countEntries();
}

function createCategory($name, $desc, $parent=NULL) {
    return CategoryDao::createCategory($name, $desc, $parent);
}

function createEntry($entryData) {
    return EntryDao::createEntry($entryData);
}

function deleteCategory($id) {
    CategoryDao::deleteCategory($id);
}

function deleteEntry($id) {
    EntryDao::deleteEntry($id);
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
    return EntryDao::getEntriesForUser($userId);
}

function getEntry($id) {
    return EntryDao::getEntry($id);
}

function increaseEntryNumViews($entry, $value=1) {
    EntryDao::increaseEntryNumViews($entry, $value);
}

function updateCategory($cat) {
    CategoryDao::updateCategory($cat);
}

function updateEntry($entry) {
    EntryDao::updateEntry($entry);
}
/* Category and entry-related functions */

/* User account-related functions */
function countUsers() {
    return UserDao::countUsers();
}

function createUser($userData) {
    return UserDao::createUser($userData);
}

function getUser($id) {
    return UserDao::getUser($id);
}

function getUserByEmail($email) {
    return UserDao::getUserByEmail($email);
}

function getUserByLoginName($loginName) {
    return UserDao::getUserByLoginName($loginName);
}

function updateUser($user) {
    UserDao::updateUser($user);
}
/* User account-related functions */
?>
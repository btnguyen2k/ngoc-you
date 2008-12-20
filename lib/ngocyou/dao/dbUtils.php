<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';

require_once 'adodb.inc.php';

require_once 'ClassLocationDao.php';
require_once 'ClassConfigDao.php';
require_once 'ClassCategoryDao.php';
require_once 'ClassEntryDao.php';
require_once 'ClassUserDao.php';
require_once 'ClassCategoryWatchDao.php';
require_once 'ClassIndexingDao.php';

define("TABLE_LOCATION", 	           "nylocation");
define("TABLE_CONFIG",   	           "nyconfig");
define("TABLE_USER",                   "nyuser");
define("TABLE_GROUP",    	           "nygroup");
define("TABLE_CATEGORY", 	           "nycategory");
define("TABLE_ENTRY",                  "nyentry");
define("TABLE_REPORTED_ENTRY",         "nyreportedentry");
define("TABLE_UPLOAD",                 "nyupload");
define("TABLE_CATEGORY_WATCH",         "nycategorywatch");
define("TABLE_KEYWORD",                "nykeyword");
define("TABLE_SEARCH",                 "nysearch");
define("TABLE_SEARCH_RESULT",          "nysearchresult");
define("TABLE_PASSWORD_RESET_REQUEST", "nypwdresetrequest");

///**
// * @var ADOConnection
// */
//$ADODB_CONN = NULL;

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
    //    /**
    //     * @var ADOConnection
    //     */
    //    global $ADODB_CONN;

    $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
    $ADODB_CONN = $app->getAdodbConnection();

    if ( $ADODB_CONN === NULL ) {
        die("Can not connect to database!");

        //        register_shutdown_function('adodbCloseConnection');
        if ( DEBUG_MODE ) {
            $ADODB_CONN->fnExecute = 'adodbCountExecs';
            $ADODB_CONN->fnCacheExecute = 'adodbCountCachedExecs';
        }
    }
    return $ADODB_CONN;
}

//function adodbCloseConnection() {
//    /**
//     * @var ADOConnection
//     */
//    global $ADODB_CONN;
//    if ( $ADODB_CONN !== NULL ) {
//        $ADODB_CONN->CompleteTrans();
//        $ADODB_CONN = NULL;
//    }
//}

/* Indexing-related functions */
function countSearchResult($searchResultId) {
    return IndexingDao::countSearchResult($searchResultId);
}

function getSearchResult($searchResultId, $page=1, $entriesPerPage=20, $sortBy=IndexingDao::SORT_TIME, $sortAsc=false) {
    return IndexingDao::getSearchResult($searchResultId, $page, $entriesPerPage, $sortBy, $sortAsc);
}

function searchEntries($query) {
    return IndexingDao::searchEntries($query);
}

function indexEntry($entry) {
	IndexingDao::indexEntry($entry);
}

function reindexEntry($entry) {
	IndexingDao::reindexEntry($entry);
}

function unindexEntry($entry) {
	IndexingDao::unindexEntry($entry);
}
/* Indexing-related functions */

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
    return EntryDao::countExpiredEntries();
}

function countEntries() {
    return EntryDao::countEntries();
}

function countEntriesForCategory($catId) {
    return EntryDao::countEntriesForCategory($catId);
}

function countReportedEntries() {
    return EntryDao::countReportedEntries();
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

function deleteExpiredEntries() {
    EntryDao::deleteExpiredEntries();
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

function getLatestEntries($numEntries, $catId=0) {
    return EntryDao::getLatestEntries($numEntries, $catId);
}

function getEntriesForCategory($catId, $page=1, $entriesPerPage=20) {
    return EntryDao::getEntriesForCategory($catId, $page, $entriesPerPage);
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

function reportEntry($entry, $reporter=NULL) {
    EntryDao::reportEntry($entry, $reporter);
}

function unreportEntry($entry) {
    EntryDao::unreportEntry($entry);
}

function updateCategory($cat) {
    CategoryDao::updateCategory($cat);
}

function updateEntry($entry) {
    EntryDao::updateEntry($entry);
}

function updateEntryExpiry($expiryDays) {
    EntryDao::updateEntryExpiry($expiryDays);
}

function getWatcherList($category) {
    return CategoryWatchDao::getWatcherList($category);
}

function isWatchingCategory($user, $category) {
    return CategoryWatchDao::isWatching($user, $category);
}

function watchCategory($user, $category) {
    CategoryWatchDao::watchCategory($user, $category);
}

function unwatchCategory($user, $category) {
    CategoryWatchDao::unwatchCategory($user, $category);
}
/* Category and entry-related functions */

/* User account-related functions */
function countUsers() {
    return UserDao::countUsers();
}

function createUser($userData) {
    return UserDao::createUser($userData);
}

function getReportedEntry($id) {
    return EntryDao::getReportedEntry($id);
}

function getAllReportedEntries() {
    return EntryDao::getAllReportedEntries();
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

function getResetPasswordCode($user) {
    return UserDao::getResetPasswordCode($user);
}

function logResetPasswordRequest($user, $resetCode) {
    UserDao::logResetPasswordRequest($user, $resetCode);
}

function removeResetPasswordRequest($user) {
    UserDao::removeResetPasswordRequest($user);
}

function updateUser($user) {
    UserDao::updateUser($user);
}
/* User account-related functions */
?>
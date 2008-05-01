<?php
require_once 'includes/denyDirectInclude.php';
require_once 'dbUtils.php';

require_once 'ClassCategory.php';
require_once 'ClassUser.php';
require_once 'ClassUserDao.php';

class CategoryWatchDao {

    /**
     * Gets list of watchers for a category.
     *
     * @param Category
     * @return Array() index array of Users
     */
    public static function getWatcherList($category) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_CATEGORY_WATCH.' WHERE categoryid=?';
        $rs = $adodb->Execute($sql, Array($category->getId()));
        if ( $rs === false ) {
            die('['.__CLASS__.'.getWatcherList()] Error: ' . $adodb->ErrorMsg());
        }
        $result = Array();
        while ( !$rs->EOF ) {
            $userId = $rs->fields['userid']+0;
            $user = UserDao::getUser($userId);
            if ( $user !== NULL ) {
                $result[] = $user;
            }
            $rs->MoveNext();
        }
        $rs->Close();
        return $result;
    }

    /**
     * Checks if a user is watching a category
     *
     * @param User
     * @param Category
     * @return bool
     */
    public static function isWatching($user, $category) {
        $adodb = adodbGetConnection();
        $sql = 'SELECT * FROM '.TABLE_CATEGORY_WATCH.' WHERE categoryid=? AND userid=?';
        $rs = $adodb->Execute($sql, Array($category->getId(), $user->getId()));
        $result = $rs !== false && !$rs->EOF;
        $rs->Close();
        return $result;
    }

    /**
     * Watches a category
     *
     * @param User
     * @param Category
     */
    public static function watchCategory($user, $category) {
        if ( self::isWatching($user, $category) ) {
            return;
        }
        $adodb = adodbGetConnection();
        $sql = 'INSERT INTO '.TABLE_CATEGORY_WATCH.' (categoryid, userid) VALUES (?, ?)';
        if ( $adodb->Execute($sql, Array($category->getId(), $user->getId())) === false ) {
            die('['.__CLASS__.'.watchCategory()] Error: ' . $adodb->ErrorMsg());
        }
    }

    /**
     * Unwatches a category
     *
     * @param User
     * @param Category
     */
    public static function unwatchCategory($user, $category) {
        $adodb = adodbGetConnection();
        $sql = 'DELETE FROM '.TABLE_CATEGORY_WATCH.' WHERE categoryid=? AND userid=?';
        if ( $adodb->Execute($sql, Array($category->getId(), $user->getId())) === false ) {
            die('['.__CLASS__.'.uwatchCategory()] Error: ' . $adodb->ErrorMsg());
        }
    }
}
?>
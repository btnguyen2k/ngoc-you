<?php
require_once 'includes/denyDirectInclude.php';
require_once 'dbUtils.php';

require_once 'ClassUser.php';

class UserDao {
    /**
     * Counts number of user accounts.
     *
     * @return integer
     */
    public static function countUsers() {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_NUM);
        $sql = 'SELECT COUNT(*) FROM '.TABLE_USER;
        $rs = $adodb->Execute($sql);
        $result = 0;
        if ( !$rs->EOF ) {
            $result = $rs->fields[0];
        }
        $rs->Close();
        return $result;
    }

    /**
     * Gets a user account by id.
     *
     * @param integer
     * @return User
     */
    public static function getUser($id) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_USER.' WHERE uid=?';
        $rs = $adodb->Execute($sql, Array($id));
        $user = NULL;
        if ( !$rs->EOF ) {
            $user = new User();
            $user->populate($rs->fields);
        }
        $rs->Close();
        return $user;
    }

    /**
     * Updates a user account.
     *
     * @param User
     */
    public static function updateUser($user) {
        $adodb = adodbGetConnection();
        $sql = 'UPDATE '.TABLE_USER.' SET uloginname=?, upassword=?, uemail=?, ufullname=? WHERE uid=?';
        $params = Array($user->getLoginName(), $user->getPassword(), $user->getEmail(),
        $user->getFullName(), $user->getId());
        if ( $adodb->Execute($sql, $params) === false ) {
            die('['.__CLASS__.'.updateUser()] Error: ' . $adodb->ErrorMsg());
        }
    }
}
?>
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
     * Creates a new user account.
     *
     * @param User
     * @return User
     */
    public static function createUser($userData) {
        $adodb = adodbGetConnection();
        $sql = "INSERT INTO ".TABLE_USER
        ." (uloginname, upassword, uemail, ufullname, ucreationtimestamp, ugroupid, uactivationcode)"
        ." VALUES(?, ?, ?, ?, ?, ?, ?)";
        $params = Array();
        $params[] = strtolower(trim($userData->getLoginName()));
        $params[] = md5(trim($userData->getPassword()));
        $params[] = strtolower(trim($userData->getEmail()));        
        $params[] = trim($userData->getFullName());
        $params[] = time();
        $groupId = $userData->getGroupId();
        if ( $groupId !== GROUP_ADMINISTRATOR && $groupId !== GROUP_MODERATOR && $groupId !== GROUP_MEMBER ) {
            $groupId = GROUP_MEMBER;
        }
        $params[] = $groupId;
        $params[] = strtolower(trim($userData->getActivationCode()));
        if ( $adodb->Execute($sql, $params) === false ) {
            die('['.__CLASS__.'.createUser()] Error: ' . $adodb->ErrorMsg());
        }
        return self::getUserByLoginName($params[0]);
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
     * Gets a user account by email.
     *
     * @param string
     * @return User
     */
    public static function getUserByEmail($email) {
        $email = strtolower(trim($email));
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_USER.' WHERE uemail=?';
        $rs = $adodb->Execute($sql, Array($email));
        $user = NULL;
        if ( !$rs->EOF ) {
            $user = new User();
            $user->populate($rs->fields);
        }
        $rs->Close();
        return $user;
    }

    /**
     * Gets a user account by login name.
     *
     * @param string
     * @return User
     */
    public static function getUserByLoginName($loginName) {
        $loginName = strtolower(trim($loginName));
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_USER.' WHERE uloginname=?';
        $rs = $adodb->Execute($sql, Array($loginName));
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
        $sql = 'UPDATE '.TABLE_USER.' SET uloginname=?, upassword=?, uemail=?, ufullname=?, uactivationcode=? WHERE uid=?';
        $params = Array($user->getLoginName(), $user->getPassword(), $user->getEmail(),
        $user->getFullName(), $user->getActivationCode(), $user->getId());
        if ( $adodb->Execute($sql, $params) === false ) {
            die('['.__CLASS__.'.updateUser()] Error: ' . $adodb->ErrorMsg());
        }
    }
}
?>
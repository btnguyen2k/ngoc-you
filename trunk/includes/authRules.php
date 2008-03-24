<?php
require_once 'denyDirectInclude.php';
require_once 'config.php';
require_once 'dao/ClassUser.php';

define('PERM_ACCESS_ADMIN_CP', 'ACCESS_ADMIN_CP');

define('PERM_MANAGE_CATEGORY', 'MANAGE_CATEGORY');
define('PERM_CREATE_CATEGORY', 'CREATE_CATEGORY');
define('PERM_DELETE_CATEGORY', 'DELETE_CATEGORY');
define('PERM_EDIT_CATEGORY'  , 'EDIT_CATEGORY');

define('PERM_VIEW_REPORTED_ADS'   , 'VIEW_REPORTED_ADS');
define('PERM_PROCESS_REPORTED_ADS', 'PROCESS_REPORTED_ADS'); //'process reported ads' has higher priority than 'delete ads'

define('PERM_DELETE_ADS', 'DELETE_ADS');

//administartor level permissions: admin can perform any action!
$ADMINISTRATOR_PERMISSIONS = Array(
	PERM_ACCESS_ADMIN_CP,
    PERM_MANAGE_CATEGORY,
    PERM_CREATE_CATEGORY,
    PERM_DELETE_CATEGORY,
    PERM_EDIT_CATEGORY,
);

//moderator level permissions
$MODERATOR_PERMISSIONS = Array(
	PERM_ACCESS_ADMIN_CP
);

$PERMISSION_RULES = Array(
    GROUP_ADMINISTRATOR => $ADMINISTRATOR_PERMISSIONS,
    GROUP_MODERATOR     => $MODERATOR_PERMISSIONS
);

/**
 * Checks a permission against a user.
 *
 * @param User
 * @param string
 * @return bool
 */
function authCheckPermission($permission, $user=NULL) {
    global $CURRENT_USER;
    global $PERMISSION_RULES;

    if ( $user === NULL ) {
        $user = $CURRENT_USER;
    }
    $groupId = $user->getGroupId();
    if ( !isset($PERMISSION_RULES[$groupId]) ) {
        return false;
    }
    $perms = $PERMISSION_RULES[$groupId];
    return in_array($permission, $perms);
}
?>
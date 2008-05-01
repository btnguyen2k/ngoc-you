<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

require_once 'adminCommons.php';
adminCheckPermission(PERM_DELETE_ADS);

deleteExpiredEntries();

header('Location: admin.php');
?>
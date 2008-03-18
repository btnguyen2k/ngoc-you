<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

deleteExpiredEntries();

header('Location: admin.php');
?>
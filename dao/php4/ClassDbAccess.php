<?php
require_once 'includes/denyDirectInclude.php';

class DbAccess {
	var $dbConn;
	var $sqlLog;
	
	function DbAccess() {
		$this->dbConn = NULL;
		$this->sqlLog = Array();
	}
	
	function getDbConn() {
		if ( $this->dbConn == NULL ) {
			$this->dbConn = $this->createDbConn();
		}
		return $this->dbConn;
	}
	
	function createDbConn() {
		die("Sub-class must override this method!");
	}
	
	function logSql($sql) {
		$this->sqlLog[] = $sql;
	}
	
	function getSqlLog() {
		return $this->sqlLog;
	}
}
?>
<?php
require_once 'includes/denyDirectInclude.php';

class DbAccess {
	var $dbConn;
	
	function DbAccess() {
		$this->dbConn = NULL;
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
}
?>
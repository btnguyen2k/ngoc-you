<?php
class User {
	var $id;
	var $loginName;
	var $password;
	var $email;
	var $fullName;
	var $groupId;
	var $creationTimestamp;
	
	function User() {
		$this->id = 0;
		$this->loginName = NULL;
		$this->password = NULL;
		$this->email = NULL;
		$this->fullName = NULL;
		$this->groupId = 0;
		$this->creationTimestamp = 0;
	}
	
	function populate($tblRow) {
		$this->id = $tblRow['uid'];
		$this->loginName = $tblRow['uloginname'];
		$this->password = $tblRow['upassword'];
		$this->email = $tblRow['uemail'];
		$this->fullName = $tblRow['ufullname'];
		$this->groupId = $tblRow['ugroupid'];
		$this->creationTimestamp = $tblRow['ucreationtimestamp'];
	}
	
	function authenticate($pwd) {
		return $this->encryptPassword($pwd) === strtolower($this->password);
	}
	
	function encryptPassword($pwd) {
		return strtolower(md5($pwd));
	}
		
	function getId() {
		return $this->id;
	}
	
	function setId($value) {
		$this->id = $value;
	}
	
	function getLoginName() {
		return $this->loginName;
	}
	
	function setLoginName($value) {
		$this->loginName = $value;
	}
	
	function getPassword() {
		return $this->password;
	}
	
	function setPassword($value) {
		$this->password = $value;
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function setEmail($value) {
		$this->email = $value;
	}
	
	function getFullName() {
		return $this->fullName;
	}
	
	function setFullName($value) {
		$this->fullName = $value;
	}
	
	function getGroupId() {
		return $this->groupId;
	}
	
	function setGroupId($value) {
		$this->groupId = $value;
	}
	
	function getCreationTimestamp() {
		return $this->creationTimestamp;
	}
	
	function setCreationTimestamp($value) {
		$this->creationTimestamp = $value;
	}
}
?>
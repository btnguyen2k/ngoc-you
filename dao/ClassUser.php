<?php
class User {
    private $id = 0;
    private $loginName = NULL;
    private $password = NULL;
    private $email = NULL;
    private $fullName = NULL;
    private $creationTimestamp = 0;
    private $groupId = 0;

    public function __construct() {
    }

    public function populate($tblRow) {
        $this->id = $tblRow['uid'];
        $this->loginName = $tblRow['uloginname'];
        $this->password = $tblRow['upassword'];
        $this->email = $tblRow['uemail'];
        $this->fullName = $tblRow['ufullname'];
        $this->groupId = $tblRow['ugroupid'];
        $this->creationTimestamp = $tblRow['ucreationtimestamp'];
    }

    public function authenticate($pwd) {
        return $this->encryptPassword($pwd) == strtolower($this->password);
    }

    public function encryptPassword($pwd) {
        return strtolower(md5($pwd));
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
    }

    public function getLoginName() {
        return $this->loginName;
    }

    public function setLoginName($value) {
        $this->loginName = $value;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($value) {
        $this->password = $value;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($value) {
        $this->fullName = $value;
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($value) {
        $this->groupId = $value;
    }

    public function getCreationTimestamp() {
        return $this->creationTimestamp;
    }

    public function setCreationTimestamp($value) {
        $this->creationTimestamp = $value;
    }
}
?>
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
        $this->setId(isset($tblRow['uid'])?$tblRow['uid']+0:0);
        $this->setLoginName(isset($tblRow['uloginname'])?$tblRow['uloginname']:NULL);
        $this->setPassword(isset($tblRow['upassword'])?$tblRow['upassword']:NULL);
        $this->setEmail(isset($tblRow['uemail'])?$tblRow['uemail']:NULL);
        $this->setFullName(isset($tblRow['ufullname'])?$tblRow['ufullname']:NULL);
        $this->setGroupId(isset($tblRow['ugroupid'])?$tblRow['ugroupid']+0:0);
        $this->setCreationTimestamp(isset($tblRow['ucreationtimestamp'])?$tblRow['ucreationtimestamp']+0:0);
    }

    public function authenticate($pwd) {
        return $this->encryptPassword($pwd) === strtolower($this->password);
    }

    public function encryptPassword($pwd) {
        return strtolower(md5($pwd));
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value+0;
    }

    public function getLoginName() {
        return $this->loginName;
    }

    public function setLoginName($value) {
        $this->loginName = $value !== NULL ? trim($value) : NULL;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($value) {
        $this->password = $value !== NULL ? trim($value) : NULL;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value !== NULL ? trim($value) : NULL;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($value) {
        $this->fullName = $value !== NULL ? trim($value) : NULL;
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($value) {
        $this->groupId = $value+0;
    }

    public function getCreationTimestamp() {
        return $this->creationTimestamp;
    }

    public function setCreationTimestamp($value) {
        $this->creationTimestamp = $value+0;
    }
}
?>
<?php
class Upload {
    private $id = NULL;
    private $entryId = NULL;
    private $fileSize = 0;
    private $mineType = NULL;
    private $fileContent = NULL;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEntryId() {
        return $this->entryId;
    }

    public function setEntryId($entryId) {
        $this->entryId = $entryId;
    }

    public function getFileContent() {
        return $this->fileContent;
    }

    public function setFileContent($fileContent) {
        $this->fileContent = $fileContent;
    }

    public function getFileSize() {
        return $this->fileSize;
    }

    public function setFileSize($fileSize) {
        $this->fileSize = $fileSize;
    }

    public function getMimeType() {
        return $this->mineType;
    }

    public function setMimeType($mimeType) {
        $this->mineType = $mimeType;
    }
    
    public function populate($tblRow) {
        $this->id = isset($tblRow['uid']) ? $tblRow['uid']+0 : NULL;
        $this->entryId = isset($tblRow['uentryid']) ? $tblRow['uentryid']+0 : NULL;
        $this->fileSize = isset($tblRow['usize']) ? $tblRow['usize']+0 : 0;
        $this->mineType = isset($tblRow['umimetype']) ? $tblRow['umimetype'] : NULL;
        $this->fileContent = isset($tblRow['ucontent']) ? $tblRow['ucontent'] : NULL;
    }
}
?>
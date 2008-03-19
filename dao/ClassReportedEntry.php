<?php
require_once 'ClassEntry.php';
class ReportedEntry {

    private $id = 0;
    private $creationTimestamp = 0;
    private $reporterId = 0;
    private $reporter = NULL;
    private $entry = NULL;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value+0;
    }

    public function getCreationTimestamp() {
        return $this->creationTimestamp;
    }
    
    public function getEntry() {
        return $this->entry;
    }
    
    public function setEntry($value) {
        $this->entry = $value;
    }

    public function setCreationTimestamp($value) {
        $this->creationTimestamp = $value+0;
    }

    public function getReporter() {
        return $this->reporter;
    }

    public function setReporter($value) {
        $this->reporter = $value;
    }

    public function getReporterId() {
        return $this->reporterId;
    }

    public function setReporterId($value) {
        $this->reporterId = $value+0;
    }

    public function populate($tblRow) {
        $this->setId(isset($tblRow['rentryid'])?$tblRow['rentryid']:0);
        $this->setCreationTimestamp(isset($tblRow['rcreationtimestamp'])?$tblRow['rcreationtimestamp']:0);
        $this->setReporterId(isset($tblRow['rreporterid'])?$tblRow['rreporterid']:0);
    }
}
?>
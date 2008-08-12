<?php
require_once 'includes/denyDirectInclude.php';
require_once 'dbUtils.php';

require_once 'ClassEntry.php';
require_once 'ClassReportedEntry.php';
require_once 'ClassCategory.php';
require_once 'ClassUser.php';
require_once 'ClassUpload.php';

class EntryDao {
    /**
     * Attaches uploaded files to an entry.
     *
     * @param Entry
     * @param Array()
     */
    public static function addUploadFilesToEntry($entry, $uploadFiles=Array()) {
        $adodb = adodbGetConnection();
        $sql = 'INSERT INTO '.TABLE_UPLOAD.' (uentryid, usize, umimetype, ucontent) VALUES (?, ?, ?, ?)';
        foreach ( $uploadFiles as $file ) {
            $eid = $entry->getId();
            $fileSize = $file['size'];
            $fileType = $file['type'];
            $fh = fopen($file['tmp_name'], 'rb');
            $fileContent = fread($fh, filesize($file['tmp_name']));
            fclose($fh);
            $adodb->Execute($sql, Array($eid, $fileSize, $fileType, $fileContent));
        }
    }

    /**
     * Deletes attachments from an entry.
     *
     * @param Entry
     * @param Array()
     */
    public static function deleteAttachmentsFromEntry($entry, $attachmentList=Array()) {
        $adodb = adodbGetConnection();
        $sql = 'DELETE FROM '.TABLE_UPLOAD.' WHERE uid=?';
        foreach ( $attachmentList as $file ) {
            $attachmentId = $file->getId();
            if ( $entry->getAttachment($attachmentId) !== NULL ) {
                $entry->deleteAttachment($attachmentId);
                $adodb->Execute($sql, Array($attachmentId));
            }
        }
    }

    /**
     * Counts number of expired entries.
     *
     * @return integer
     */
    public static function countExpiredEntries() {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_NUM);
        $sql = 'SELECT COUNT(*) FROM '.TABLE_ENTRY.' WHERE eexpirytimestamp <= ?';
        $rs = $adodb->Execute($sql, Array(time()));
        $result = 0;
        if ( !$rs->EOF ) {
            $result = $rs->fields[0];
        }
        $rs->Close();
        return $result;
    }

    /**
     * Counts number of reported entries.
     *
     * @return integer
     */
    public static function countReportedEntries() {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_NUM);
        $sql = 'SELECT COUNT(*) FROM '.TABLE_REPORTED_ENTRY;
        $rs = $adodb->Execute($sql);
        $result = 0;
        if ( !$rs->EOF ) {
            $result = $rs->fields[0];
        }
        $rs->Close();
        return $result;
    }

    /**
     * Counts number of non-expired entries.
     *
     * @return integer
     */
    public static function countEntries() {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_NUM);
        $sql = 'SELECT COUNT(*) FROM '.TABLE_ENTRY.' WHERE eexpirytimestamp > ?';
        $rs = $adodb->Execute($sql, Array(time()));
        $result = 0;
        if ( !$rs->EOF ) {
            $result = $rs->fields[0];
        }
        $rs->Close();
        return $result;
    }

    /**
     * Creates a new entry.
     *
     * @param Array()
     * @return Entry
     */
    public static function createEntry($entryData) {
        $adodb = adodbGetConnection();
        $sql = 'INSERT INTO '.TABLE_ENTRY
        .' (ecatid, euserid, ecreationtimestamp, eexpirytimestamp, etitle, ebody, etype, eprice, elocation, ehtml)'
        .' VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $current = time();
        $params = Array($entryData['category']->getId(), $entryData['user']->getId(), $current);
        $params[] = $current + $entryData['expiry'];
        $params[] = $entryData['adsTitle'];
        $params[] = $entryData['adsContent'];
        $params[] = $entryData['adsType'];
        $params[] = $entryData['adsPrice'];
        $params[] = $entryData['adsLocation'];
        $params[] = $entryData['html'];
        if ( $adodb->Execute($sql, $params) === false ) {
            die('['.__CLASS__.'.createEntry()] Error: ' . $adodb->ErrorMsg());
        }
        $id = $adodb->Insert_ID();
        if ( $id !== false ) {
            return self::getEntry($id);
        }
        return NULL;
    }

    /**
     * Deletes expired entries.
     */
    public static function deleteExpiredEntries() {
        $adodb = adodbGetConnection();
        $sql = 'DELETE FROM '.TABLE_ENTRY.' WHERE eexpirytimestamp <= ?';
        if ( $adodb->Execute($sql, Array(time())) === false ) {
            die('['.__CLASS__.'.deleteExpiredEntries()] Error: ' . $adodb->ErrorMsg());
        }
    }

    /**
     * Deletes an entry.
     *
     * @param integer
     */
    public static function deleteEntry($id) {
        $adodb = adodbGetConnection();
        $sql = 'DELETE FROM '.TABLE_ENTRY.' WHERE eid=?';
        if ( $adodb->Execute($sql, Array($id)) === false ) {
            die('['.__CLASS__.'.deleteEntry()] Error: ' . $adodb->ErrorMsg());
        }
    }

    /**
     * Gets an entry by id.
     *
     * @param integer
     * @return Entry
     */
    public static function getEntry($id) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_ENTRY.' WHERE eid=?';
        $rs = $adodb->Execute($sql, Array($id));
        $entry = NULL;
        if ( !$rs->EOF ) {
            $entry = new Entry();
            $entry->populate($rs->fields);
            self::populateExtraInfo($entry);
        }
        $rs->Close();
        return $entry;
    }

    /**
     * Gets all non-expired entries for a category.
     *
     * @param int
     * @param int
     * @param int
     * @return Array()
     */
    public static function getEntriesForCategory($catId, $page=1, $entriesPerPage=20) {
        $cat = CategoryDao::getCategory($catId);
        if ( $cat === NULL ) {
            return Array();
        }
        $params = Array($catId);
        foreach ( $cat->getChildren() as $child ) {
            $params[] = $child->getId();
        }
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $catIdsParam = Ddth_Adodb_AdodbHelper::buildArrayParams(count($params));        
        $sql = 'SELECT * FROM '.TABLE_ENTRY.' WHERE ecatid IN ('.$catIdsParam.') AND eexpirytimestamp>? ORDER BY eexpirytimestamp DESC';
        $params[] = time();
        $rs = $adodb->SelectLimit($sql, $entriesPerPage, ($page-1)*$entriesPerPage, $params);
        //$rs = $adodb->Execute($sql, Array($catId, time()));
        $result = Array();
        while ( !$rs->EOF ) {
            $entry = new Entry();
            $entry->populate($rs->fields);
            self::populateExtraInfo($entry);
            $result[] = $entry;
            $rs->MoveNext();
        }
        $rs->Close();
        return $result;
    }

    /**
     * Gets all non-expired entries for a user.
     *
     * @param int
     * @return Array()
     */
    public static function getEntriesForUser($userId) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_ENTRY.' WHERE euserid=? AND eexpirytimestamp>? ORDER BY eexpirytimestamp DESC';
        $rs = $adodb->Execute($sql, Array($userId, time()));
        $result = Array();
        while ( !$rs->EOF ) {
            $entry = new Entry();
            $entry->populate($rs->fields);
            self::populateExtraInfo($entry);
            $result[] = $entry;
            $rs->MoveNext();
        }
        $rs->Close();
        return $result;
    }

    /**
     * Populates extra information to an reported entry.
     *
     * @param ReportedEntry
     */
    private static function populateReportedExtraInfo($entry) {
        $entry->setReporter(UserDao::getUser($entry->getReporterId()));
        $entry->setEntry(self::getEntry($entry->getId()));
    }

    /**
     * Gets a reported entry.
     *
     * @param integer
     * @return ReportedEntry
     */
    public static function getReportedEntry($id) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_REPORTED_ENTRY.' WHERE rentryid=?';
        $rs = $adodb->Execute($sql, Array($id));
        $result = NULL;
        if ( !$rs->EOF ) {
            $result = new ReportedEntry();
            $result->populate($rs->fields);
            self::populateReportedExtraInfo($result);
        }
        $rs->Close();
        return $result;
    }

    /**
     * Gets all reported entries.
     *
     * @return Array()
     */
    public static function getAllReportedEntries() {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_REPORTED_ENTRY.' ORDER BY rcreationtimestamp DESC';
        $rs = $adodb->Execute($sql);
        if ( $rs === false ) {
            die('['.__CLASS__.'.getAllReportedEntries()] Error: ' . $adodb->ErrorMsg());
        }
        $result = Array();
        while ( !$rs->EOF ) {
            $entry = new ReportedEntry();
            $entry->populate($rs->fields);
            self::populateReportedExtraInfo($entry);
            $result[] = $entry;
            $rs->MoveNext();
        }
        $rs->Close();
        return $result;
    }

    /**
     * Increases entry's number of views.
     *
     * @param Entry
     * @param integer
     */
    public static function increaseEntryNumViews($entry, $value=1) {
        $entry->setNumViews($entry->getNumViews() + $value);
        self::updateEntry($entry);
    }

    /**
     * Reports an entry to administrators
     *
     * @param Entry
     * @param User
     */
    public static function reportEntry($entry, $reporter=NULL) {
        $reportedEntry = self::getReportedEntry($entry->getId());
        if ( $reportedEntry !== NULL ) {
            //ads has been already reported!
            return;
        }
        $adodb = adodbGetConnection();
        $sql = 'INSERT INTO '.TABLE_REPORTED_ENTRY.' (rentryid, rcreationtimestamp, rreporterid) VALUES (?, ?, ?)';
        $params = Array($entry->getId(), time(), $reporter!==NULL?$reporter->getId():NULL);
        if ( $adodb->Execute($sql, $params)===false ) {
            die('['.__CLASS__.'.reportEntry()] Error: ' . $adodb->ErrorMsg());
        }
    }
	
	/**
     * Un-reports an reported entry.
     *
     * @param Entry
     */
    public static function unreportEntry($entry) {
		$adodb = adodbGetConnection();
        $sql = 'DELETE FROM '.TABLE_REPORTED_ENTRY.' WHERE rentryid = ?';
        $params = Array($entry->getId());
        if ( $adodb->Execute($sql, $params)===false ) {
            die('['.__CLASS__.'.unreportEntry()] Error: ' . $adodb->ErrorMsg());
        }
    }

    /**
     * Update an entry.
     *
     * @param Entry
     */
    public static function updateEntry($entry) {
        $adodb = adodbGetConnection();
        $sql = 'UPDATE '.TABLE_ENTRY.' SET ecatid=?, eexpirytimestamp=?, etitle=?, ebody=?, enumviews=?'
        .', etype=?, eprice=?, elocation=?, ehtml=? WHERE eid=?';
        $params = Array($entry->getCategoryId(), $entry->getExpiryTimestamp(),
        $entry->getTitle(), $entry->getContent(), $entry->getNumViews(),
        $entry->getType(), $entry->getPrice(), $entry->getLocation(), $entry->isHtml(),
        $entry->getId());
        if ( $adodb->Execute($sql, $params)===false ) {
            die('['.__CLASS__.'.updateEntry()] Error: ' . $adodb->ErrorMsg());
        }
    }

    /**
     * Populates extra information to an entry.
     *
     * @param Entry
     */
    private static function populateExtraInfo($entry) {
        self::populateAttachments($entry);
        self::populatePoster($entry);
        self::populateCategory($entry);
    }

    /**
     * Populates category information to an entry.
     *
     * @param Entry
     */
    private static function populateCategory($entry) {
        $entry->setCategory(CategoryDao::getCategory($entry->getCategoryId()));
    }

    /**
     * Populates poster information to an entry.
     *
     * @param Entry
     */
    private static function populatePoster($entry) {
        $entry->setPoster(UserDao::getUser($entry->getUserId()));
    }

    /**
     * Populates attachment information to an entry.
     *
     * @param Entry
     */
    private static function populateAttachments($entry) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_UPLOAD.' WHERE uentryid=?';
        $rs = $adodb->Execute($sql, Array($entry->getId()));
        while ( !$rs->EOF ) {
            $upload = new Upload();
            $upload->populate($rs->fields);
            $entry->addAttachment($upload);
            $rs->MoveNext();
        }
        $rs->Close();
    }
}
?>
<?php
require_once 'includes/denyDirectInclude.php';
require_once 'dbUtils.php';

require_once 'ClassEntry.php';

class EntryDao {
    /**
     * Gets all non-expired entries for a category.
     *
     * @param int
     * @return Array()
     */
    public static function getEntriesForCategory($catId) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_ENTRY.' WHERE ecatid=? AND eexpirytimestamp>? ORDER BY eexpirytimestamp DESC';
        $rs = $adodb->Execute($sql, Array($catId, time()));
        $result = Array();
        while ( !$rs->EOF ) {
            $entry = new Entry();
            $entry->populate($row);
            $result[] = $entry;
        }
        $rs->Close();
        return $result;
    }
}
?>
<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/utils.php';
require_once 'dbUtils.php';

require_once 'ClassEntry.php';
require_once 'ClassCategory.php';
require_once 'ClassSearchQuery.php';
require_once 'ClassSearchResult.php';

class IndexingDao {
    
    const SORT_TIME = 0;
    
    /**
     * Counts number of hits for a search result.
     *
     * @param int
     * @return int
     */
    public static function countSearchResult($searchResultId) {
        $searchResultId += 0;
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_NUM);
        $sql = 'SELECT count(sentryid) FROM '.TABLE_SEARCH_RESULT.' WHERE sid=?';
        $rs = $adodb->Execute($sql, Array($searchResultId));
        $result = 0;
        if ( !$rs->EOF ) {
            $result = $rs->fields[0];
        }
        $rs->Close();
        return $result;        
    }
    
    /**
     * Retrieves entries from a search result
     *
     * @param int
     * @param int
     * @param int
     * @param int
     * @param boolean
     * @return SearchResult
     */
    public static function getSearchResult($searchResultId, $page=1, $entriesPerPage=20, $sortBy=self::SORT_TIME, $sortAsc=false) {
        $searchResultId += 0;
        $page += 0; if ( $page < 1 ) { $page = 1; }
        $entriesPerPage += 0; if ( $entriesPerPage < 1 ) { $entriesPerPage = 1; }
        
        $tableList = Array(TABLE_SEARCH_RESULT.' AS sr', TABLE_ENTRY.' AS e');
        $whereClause = Array('sr.sentryid=e.eid', 'sr.sid='.$searchResultId);

        $sql = 'SELECT sr.sentryid AS entryid FROM ' . implode(',', $tableList);
        $sql .= ' WHERE ' . implode(' AND ', $whereClause);
        $sql .= ' ORDER BY e.eexpirytimestamp ' . $sortAsc ? '' : 'DESC';

        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $rs = $adodb->SelectLimit($sql, $entriesPerPage, ($page-1)*$entriesPerPage);
        if ( $rs === false ) {
            die('['.__CLASS__.'.getSearchResult()] Error: ' . $adodb->ErrorMsg());
        }
        
        $result = new SearchResult($searchResultId);
        while ( !$rs->EOF ) {
            $entryId = $rs->fields['entryid'];
            $entry = EntryDao::getEntry($entryId);
            if ( $entry != NULL ) {
                $result->addAds($entry);
            }
            $rs->MoveNext();
        }
        $rs->Close();

        return $result;
    }

    /**
     * Index an entry.
     *
     * @param Entry
     */
    public static function indexEntry($entry) {
        $content = trim(strip_tags($entry->getTitle())) . ' ' . trim(strip_tags($entry->getContent()));
        $keywords = tokenizeSearchQuery($content);

        $eid = $entry->getId();
        $sql = 'INSERT INTO '.TABLE_KEYWORD.' (kword, kentryid) VALUES (?, '.$eid.')';
        $adodb = adodbGetConnection();
        foreach ( $keywords as $word ) {
            if ( $adodb->Execute($sql, Array($word)) === false ) {
                die('['.__CLASS__.'.indexEntry()] Error: ' . $adodb->ErrorMsg());
            }
        }
    }

    /**
     * Reindex an entry.
     *
     * @param Entry
     */
    public static function reindexEntry($entry) {
        self::unindexEntry($entry);
        self::indexEntry($entry);
    }

    /**
     * Unindex an entry.
     *
     * @param Entry
     */
    public static function unindexEntry($entry) {
        $adodb = adodbGetConnection();
        $sql = 'DELETE FROM '.TABLE_KEYWORD.' WHERE kentryid=?';
        if ( $adodb->Execute($sql, Array($entry->getId())) === false ) {
            die('['.__CLASS__.'.unindexEntry()] Error: ' . $adodb->ErrorMsg());
        }
    }

    /**
     * Searches for entries.
     *
     * @param SearchQuery
     * @return int id of search result
     */
    public static function searchEntries($query) {
        $queryStr = $query->getQuery();
        $keywords = tokenizeSearchQuery($queryStr);
        if ( count($keywords) < 1 ) {
            return 0;
        }

        $tableList = Array(TABLE_KEYWORD.' AS kw', TABLE_ENTRY.' AS e');
        $whereClause = Array('kw.kentryid=e.eid');

        /* where clause 1: keyword */
        $whereClause[] = 'kw.kword IN ('.Ddth_Adodb_AdodbHelper::buildArrayParams(count($keywords)).')';

        /* where clause 2: category */
        $catList = $query->getCategoryList();
        if ( count($catList) > 0 ) {
            $whereClause[] = 'e.ecatid IN ('.Ddth_Adodb_AdodbHelper::buildArrayParams(count($catList)).')';
        }

        /* where clause 3: location */
        $locationList = $query->getLocationList();
        if ( count($locationList) > 0 ) {
            $whereClause[] = 'e.elocation IN ('.Ddth_Adodb_AdodbHelper::buildArrayParams(count($locationList)).')';
        }

        $sql = 'SELECT kw.kentryid AS entryid FROM ' . implode(',', $tableList);
        $sql .= ' WHERE ' . implode(' AND ', $whereClause);

        $params = Array();
        foreach ( $keywords as $word ) {
            $params[] = $word;
        }
        foreach ( $catList as $cat ) {
            $params[] = $cat->getId();
        }
        foreach ( $locationList as $loc ) {
            $params[] = $loc;
        }

        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $rs = $adodb->Execute($sql, $params);
        if ( $rs === false ) {
            die('['.__CLASS__.'.searchEntries()] Error: ' . $adodb->ErrorMsg());
        }
        
        $searchId = self::createSearchRecord($queryStr);
        $hasResult = false;
        while ( !$rs->EOF ) {
            $hasResult = true;
            $entryId = $rs->fields['entryid'];
            $adodb->Execute('INSERT INTO '.TABLE_SEARCH_RESULT.'(sid, sentryid) VALUES (?, ?)', Array($searchId, $entryId));
            $rs->MoveNext();
        }
        $rs->Close();
        
        if ( $hasResult ) {
            return $searchId;
        } else {
            self::deleteSearchRecord($searchId);
            return 0;
        }
    }

    /**
     * Creates a search record.
     *
     * @param string search query string
     * @return int id of search record entry
     */
    private static function createSearchRecord($queryStr) {
        $queryStr = trim($queryStr);
        if ( strlen($queryStr) > 64 ) {
            $queryStr = trim(substr($queryStr, 0, 64));
        }

        $adodb = adodbGetConnection();
        $sql = 'INSERT INTO '.TABLE_SEARCH.' (skeyword, stimestamp) VALUES (?, ?)';
        if ( $adodb->Execute($sql, Array($queryStr, time())) === false ) {
            die('['.__CLASS__.'.createSearchRecord()] Error: ' . $adodb->ErrorMsg());
        }
        $id = $adodb->Insert_ID();
        return $id !== false ? $id : NULL;
    }

    /**
     * Deletes a search record.
     *
     * @param int id of search record entry to delete.
     */
    private static function deleteSearchRecord($id) {
        $adodb = adodbGetConnection();
        $sql = 'DELETE FROM '.TABLE_SEARCH.' WHERE sid=?';
        if ( $adodb->Execute($sql, Array($id)) === false ) {
            die('['.__CLASS__.'.deleteSearchRecord()] Error: ' . $adodb->ErrorMsg());
        }
    }
}
?>
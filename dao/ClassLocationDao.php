<?php
require_once 'includes/denyDirectInclude.php';
require_once 'dbUtils.php';

class LocationDao {
    
    private static $allLocations = NULL;
    
    /**
     * Gets all defined locations
     *
     * @return Array()
     */
    public static function getAllLocations() {
        if ( self::$allLocations === NULL ) {
            $adodb = adodbGetConnection();
            $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
            $sql = 'SELECT * FROM '.TABLE_LOCATION;
            $rs = $adodb->Execute($sql);
            self::$allLocations = Array();
            while ( !$rs->EOF ) {
                $key = $rs->fields['lid'];
                $value = $rs->fields['lname'];
                self::$allLocations[$key] = $value;
                $rs->MoveNext();
            }
            $rs->Close();
        }
        return self::$allLocations;
    }
}
?>
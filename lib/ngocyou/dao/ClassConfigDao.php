<?php
require_once 'includes/denyDirectInclude.php';
require_once 'dbUtils.php';

class ConfigDao {

    private static $allConfigs = NULL;

    /**
     * Gets all configurations.
     *
     * @return Array()
     */
    public static function getAllConfigs() {
        if ( self::$allConfigs === NULL ) {
            $adodb = adodbGetConnection();
            $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
            $sql = 'SELECT * FROM '.TABLE_CONFIG;
            $rs = $adodb->Execute($sql);
            self::$allConfigs = Array();
            while ( !$rs->EOF ) {
                $key = $rs->fields['ckey'];
                $value = $rs->fields['cvalue'];
                self::$allConfigs[$key] = $value;
                $rs->MoveNext();
            }
            $rs->Close();
        }
        return self::$allConfigs;
    }

    /**
     * Gets a configuration value.
     *
     * @param string
     * @return string
     */
    public static function getConfig($key) {
        $allConfig = self::getAllConfigs();
        return isset($allConfig[$key]) ? $allConfig[$key] : NULL;
    }

    /**
     * Updates a configuration.
     *
     * @param string
     * @param string
     */
    public static function updateConfig($key, $value) {
        $adodb = adodbGetConnection();
        $sql = 'UPDATE '.TABLE_CONFIG.' SET cvalue=? WHERE ckey=?';
        if ( $adodb->Execute($sql, Array($value, $key)) === false ) {
            die('['.__CLASS__.'.updateConfig()] Error: ' . $adodb->ErrorMsg());
        }
        self::$allConfigs = NULL;
    }
}
?>
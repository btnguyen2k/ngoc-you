<?php
class ConfigDao {
    /**
     * Gets a configuration value.
     *
     * @param string
     * @return string
     */
    public static function getConfig($key) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_NUM);
        $sql = 'SELECT cvalue FROM '.TABLE_CONFIG.' WHERE ckey=?';
        $rs = $adodb->Execute($sql, Array($key));
        $result = NULL;
        if ( !$rs->EOF ) {
            $result = $rs->fields[0];
        }
        $rs->Close();
        return $result;
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
    }
}
?>
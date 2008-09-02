<?php
/**
 * Compare 2 language files.
 * 
 * Usage:
 * 
 *     php cmplangfiles.php <file1.properties> <file2.properties>
 */

if ( count($argv) < 3 ) {
    echo "Usage:\n";
    echo "\tphp cmplangfiles.php <lang_file_1.properties> <lang_file_2.properties>";
    echo "\n";
    exit;
}

if ( !function_exists('__autoload') ) {
    /**
     * Automatically loads class source file when used.
     *
     * @param string
     * @ignore
     */
    function __autoload($className) {        
        require_once 'Ddth/Commons/ClassDefaultClassNameTranslator.php';
        require_once 'Ddth/Commons/ClassLoader.php';
        $translator = Ddth_Commons_DefaultClassNameTranslator::getInstance();
        if ( !Ddth_Commons_Loader::loadClass($className, $translator) ) {
            echo("Can not load class [$className]!");
            trigger_error("Can not load class [$className]!");
        }
    }
}

/*
 * This is the directory where configuration files are stored.
 * It should not be reachable from the web.
 */
define('CONFIG_DIR', 'config');
if ( !is_dir(CONFIG_DIR) ) {
    exit('Invalid CONFIG_DIR setting!');
}

/*
 * This is the directory where 3rd party libraries are located.
 * All 1st level sub-directories of this directory will be included
 * in the include_path
 */
define('LIBS_DIR', 'lib');
if ( !is_dir(LIBS_DIR) ) {
    exit('Invalid LIBS_DIR setting!');
}

/* set up include path */
$includePath = '.'.PATH_SEPARATOR.CONFIG_DIR;
if ( $dh = @opendir(LIBS_DIR) ) {
    while ( ($file = readdir($dh)) !== false ) {
        if ( is_dir(LIBS_DIR."/$file") && $file!="." && $file!=".." ) {
            $includePath .= PATH_SEPARATOR.LIBS_DIR."/$file";
        }
    }
} else {
    exit('Can not open LIBS_DIR!');
}
ini_set('include_path', $includePath);

//load language file 1
$lang1 = new Ddth_Commons_Properties();
$lang1->load($argv[1]);

//load language file 2
$lang2 = new Ddth_Commons_Properties();
$lang2->load($argv[2]);

$keys1 = $lang1->keys();
$keys2 = $lang2->keys();

$masterNotInReplica = Array();
$replicaNotInMaster = Array();
foreach ( $keys1 as $k ) {
    if ( !in_array($k, $keys2) ) {
        $masterNotInReplica[] = $k;
    }
}
foreach ( $keys2 as $k ) {
    if ( !in_array($k, $keys1) ) {
        $replicaNotInMaster[] = $k;
    }
}

var_dump($masterNotInReplica);
var_dump($replicaNotInMaster);
?>

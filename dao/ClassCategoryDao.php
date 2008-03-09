<?php
require_once 'includes/denyDirectInclude.php';
require_once 'dbUtils.php';

require_once 'ClassCategory.php';

class CategoryDao {

    private static $categoryTree = NULL;
    private static $categoryList = NULL;
    private static $categoryMap = NULL;

    /**
     * Counts number of available categories.
     *
     * @return integer
     */
    public static function countCategories() {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_NUM);
        $sql = 'SELECT COUNT(*) FROM '.TABLE_CATEGORY;
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
     * Creates a new category.
     *
     * @param string
     * @param string
     * @param Category
     * @return Category the newly created category
     */
    public static function createCategory($name, $desc, $parent=NULL) {
        $adodb = adodbGetConnection();
        $sql = 'INSERT INTO '.TABLE_CATEGORY.'(cname, cdesc, cposition, cparentid) VALUES (?, ?, ?, ?)';
        $params = Array($name, $desc);
        if ( $parent !== NULL ) {
            $params[] = $parent->getNumChildren()+1; //position
            $params[] = $parent->getId(); //parentId
        } else {
            $pos = count(self::getCategoryTree())+1;
            $params[] = $pos; //position
            $params[] = NULL; //parentId
        }
        if ( $adodb->Execute($sql, $params) === false ) {
            die('['.__CLASS__.'.createCategory()] Error: ' . $adodb->ErrorMsg());
        }
        self::clearCategoryCache();
        $id = $adodb->Insert_ID();
        if ( $id !== false ) {
            return self::getCategory($id);
        }
        return NULL;
    }
    
    /**
     * Deletes a category.
     *
     * @param integer
     */
    public static function deleteCategory($id) {
        $adodb = adodbGetConnection();
		$sql = 'DELETE FROM '.TABLE_CATEGORY.' WHERE cid=?';
		if ( $adodb->Execute($sql, Array($id)) === false ) {
			die('['.__CLASS__.'.deleteCategory()] Error: ' . $adodb->ErrorMsg());
		}
		self::clearCategoryCache();
    }

    /**
     * Gets a category by id.
     *
     * @param integer
     * @return Category
     */
    public static function getCategory($id) {
        self::loadCategories();
        $catsMap = self::$categoryMap;
        return $catsMap !== NULL && isset($catsMap[$id]) ? $catsMap[$id] : NULL;
    }

    /**
     * Gets all available categories as a tree.
     *
     * @return Array()
     */
    public static function getCategoryTree() {
        self::loadCategories();
        return self::$categoryTree !== NULL ? self::$categoryTree : Array();
    }

    /**
     * Counts number of ads entries for a category
     *
     * @param integer
     * @return integer
     */
    public function countEntriesForCategory($catId) {
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_NUM);
        $sql = 'SELECT COUNT(*) FROM '.TABLE_ENTRY.' WHERE ecatid=? AND eexpirytimestamp>?';
        $rs = $adodb->Execute($sql, Array($catId+0, time()));
        $result = 0;
        if ( !$rs->EOF ) {
            $result = $rs->fields[0];
        }
        $rs->Close();
        return $result;
    }

    /**
     * Updates a category data.
     *
     * @param Category
     */
    public function updateCategory($cat) {
        $adodb = adodbGetConnection();
        $sql = 'UPDATE '.TABLE_CATEGORY.' SET cparentId=?, cposition=?, cname=?, cdesc=? WHERE cid=?';
        $params = Array(NULL, $cat->getPosition(), $cat->getName(),
        $cat->getDescription(), $cat->getId());
        if ( $cat->getParentId() > 0 ) {
            $params[0] = $cat->getParentId();
        }
        if ( $adodb->Execute($sql, $params)===false ) {
            die('['.__CLASS__.'.updateCategory()] Error: ' . $adodb->ErrorMsg());
        }
        self::clearCategoryCache();
    }

    /**
     * Clears category caches.
     */
    private function clearCategoryCache() {
        self::$categoryList = NULL;
        self::$categoryMap = NULL;
        self::$categoryTree = NULL;
    }

    /**
     * Loads all categories and builds category structures.
     */
    private function loadCategories() {
        $catsList = self::$categoryList;
        if ( $catsList !== NULL ) return;

        $catsList = Array();
        $catsMap = Array();
        $catsTree = Array();
        $adodb = adodbGetConnection();
        $adodb->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = 'SELECT * FROM '.TABLE_CATEGORY.' ORDER BY cparentid, cposition DESC';
        $rs = $adodb->Execute($sql);
        while ( !$rs->EOF ) {
            $cat = new Category();
            $cat->populate($rs->fields);
            $cat->setNumEntries(self::countEntriesForCategory($cat->getId()));
            $catsList[] = $cat;
            $id = $cat->getId();
            $parentId = $cat->getParentId();
            $catsMap[$id] = $cat;
            if ( isset($catsMap[$parentId]) ) {
                $catsMap[$parentId]->addChild($cat);
            }
            if ( $parentId < 1 ) {
                $catsTree[] = $cat;
            }
            $rs->MoveNext();
        }
        $rs->Close();
        self::$categoryList = $catsList;
        self::$categoryTree = $catsTree;
        self::$categoryMap = $catsMap;
    }
}
?>
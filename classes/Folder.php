<?php
/**
 * Table Definition for folder
 */
require_once 'DB/DataObject.php';

require_once 'Folder_reference.php';

class Folder extends DB_DataObject
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'folder';                          // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $parent_id;                       // int(11)  multiple_key
    var $text_en;                         // string(200)
    var $text_fr;                         // string(200)
    var $text_de;                         // string(200)
    var $text_nl;                         // string(200)
    var $text_es;                         // string(200)
    var $text_it;                         // string(200)
    var $number;                          // string(5)  not_null
    var $sort_order;                      // int(11)

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Folder',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function addWork($work)
    {
        // Insert the work into the folder... and if this causes a duplicate,
        // just do some meaningless busywork to avoid an error.
        $sql = "INSERT INTO work_folder (work_id, folder_id) " .
            "VALUES('$work->id', '$this->id') " .
            "ON DUPLICATE KEY UPDATE work_id=work_id";
        return $this->query($sql);
    }
    
    /**
     * Creates and returns a folder, sorted by language
     *
     * @return Folder object
     */
    function createSortedFolder() {
        $folder = new Folder();
        // checks if our cookie is set to a valid language against available translation files
        $lang = ($_COOKIE['language'] && file_exists(dirname(__FILE__).'/../translations/'.$_COOKIE['language'].'.inc'))
            ? $_COOKIE['language']
            : 'fr';
        $folder->orderBy('sort_order,text_'.$lang);
        return $folder;
    }

    /**
     * Try to load a folder based on an ID value.  Note that we need to do some
     * extra work to account for the possibility of merged folders; this allows
     * bookmarked URLs to remain valid even after a folder no longer exists in
     * the database.
     *
     * @param   int     $id                 ID to look up.
     * @return  bool                        True if ID found, false otherwise.
     * @access  public
     */
    public function lookupById($id)
    {
        $safeId = $this->escape($id);
        $sql = "SELECT * FROM folder WHERE id='{$safeId}' OR id IN " .
            "(SELECT dest_folder_id FROM folder_merge_history WHERE source_folder_id='{$safeId}')";
        $this->query($sql);
        if ($this->N) {
            $this->fetch();
            return true;
        }
        return false;
    }

    function getWorks()
    {
        $workList = array();

        $sql = "SELECT `work`.* FROM `work`, work_folder WHERE `work`.id = work_folder.work_id AND work_folder.folder_id = '$this->id'";

        $work = new Work();
        $work->query($sql);
        if ($work->N) {
            while ($work->fetch()) {
                $workList[] = clone($work);
            }
        }

        return $workList;
    }

    function hasWorks()
    {
        $sql = "SELECT COUNT(*) as workCount FROM `work`, work_folder WHERE `work`.id = work_folder.work_id AND work_folder.folder_id = '$this->id'";

        $this->query($sql);
        return $this->workCount;
    }

    function removeWork($work)
    {
        $sql = "DELETE FROM work_folder WHERE work_id = '$work->id' AND folder_id = '$this->id'";
        return $this->query($sql);
    }

    function getParent()
    {
        if ($this->parent_id != null) {
            return Folder::staticGet('id', $this->parent_id);
        } else {
            return null;
        }
    }

    function getChildren($limit = null)
    {
        $children = array();

        $folder = $this->createSortedFolder();
        $folder->parent_id = $this->id;
        if ($limit) {
            $folder->limit($limit);
        }
        if ($folder->find()) {
            while ($folder->fetch()) {
                $children[] = clone($folder);
            }
        }
        return $children;
    }

    function hasChildren()
    {
        $folder = new Folder();
        $folder->parent_id = $this->id;
        if ($folder->count()) {
            return true;
        } else {
            return false;
        }
    }

    function getSiblings()
    {
        $siblingList = array();

        $folder = $this->createSortedFolder();
        if ($this->parent_id == null) {
            $folder->parent_id = 'null';
        } else {
            $folder->parent_id = $this->parent_id;
        }
        if ($folder->find()) {
            while ($folder->fetch()) {
                $siblingList[] = clone($folder);
            }
        }

        return $siblingList;
    }

    function getParentIdChain($reverse = false)
    {
        // We need a subset of the data returned by getParentChain; let's latch
        // onto that existing functionality rather than trying to replicate its
        // logic here.  This way we don't have to worry about remembering to keep
        // adjustments to its safety mechanisms in sync in two places.
        $list = $this->getParentChain($reverse);
        $idList = array();
        foreach($list as $current) {
            $idList[] = $current->id;
        }
        return $idList;
    }

    function getParentChain($reverse = false)
    {
        $parentList = array();

        // This is a safety check against circular references -- if we encounter
        // an ID more than once, we break to avoid an infinite loop.
        $encounteredIds = array($this->id);

        $current = $this;
        while ($current->parent_id != null && !in_array($current->parent_id, $encounteredIds)) {
            $current = Folder::staticGet('id', $current->parent_id);
            $encounteredIds[] = $current->id;
            $parentList[] = $current;
        }

        if ($reverse) {
            $parentList = array_reverse($parentList);
        }

        return $parentList;
    }

    function getReferences()
    {
        $referenceList = array();

        $sql = "SELECT folder.* FROM folder, folder_reference " .
               "WHERE folder.id = folder_reference.reference_id AND folder_reference.folder_id = '$this->id'";

        $folder = $this->createSortedFolder();
        $folder->query($sql);
        if ($folder->N) {
            while ($folder->fetch()) {
                $referenceList[] = $folder;
            }
        }

        return $referenceList;
    }

    function removeReferences()
    {
        $reference = new Folder_reference();
        $reference->folder_id = $this->id;
        $reference->delete();
    }

    function addReference($folder)
    {
        $reference = new Folder_reference();
        $reference->folder_id = $this->id;
        $reference->reference_id = $folder->id;
        $reference->insert();
    }
}

?>

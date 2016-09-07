<?php
/**
 * Table Definition for folder_reference
 */
require_once 'DB/DataObject.php';

class Folder_reference extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'folder_reference';                // table name
    var $folder_id;                       // int(11)  not_null primary_key
    var $reference_id;                    // int(11)  not_null primary_key multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Folder_reference',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

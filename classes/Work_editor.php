<?php
/**
 * Table Definition for work_editor
 */
require_once 'DB/DataObject.php';

class Work_editor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'work_editor';                     // table name
    var $work_id;                         // int(11)  not_null primary_key
    var $editor_id;                       // int(11)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Work_editor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

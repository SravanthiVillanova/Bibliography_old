<?php
/**
 * Table Definition for work_folder
 */
require_once 'DB/DataObject.php';

class Work_folder extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'work_folder';                     // table name
    var $work_id;                         // int(11)  not_null multiple_key
    var $folder_id;                       // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Work_folder',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

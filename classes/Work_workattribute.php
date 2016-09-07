<?php
/**
 * Table Definition for work_workattribute
 */
require_once 'DB/DataObject.php';

class Work_workattribute extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'work_workattribute';              // table name
    var $work_id;                         // int(11)  not_null primary_key
    var $workattribute_id;                // int(11)  not_null primary_key multiple_key
    var $value;                           // blob(65535)  blob

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Work_workattribute',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

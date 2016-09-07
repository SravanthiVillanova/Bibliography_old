<?php
/**
 * Table Definition for worktype_workattribute
 */
require_once 'DB/DataObject.php';

class Worktype_workattribute extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'worktype_workattribute';          // table name
    var $worktype_id;                     // int(11)  not_null primary_key
    var $workattribute_id;                // int(11)  not_null primary_key multiple_key
    var $rank;                            // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Worktype_workattribute',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

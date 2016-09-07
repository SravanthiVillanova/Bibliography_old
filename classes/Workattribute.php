<?php
/**
 * Table Definition for workattribute
 */
require_once 'DB/DataObject.php';

class Workattribute extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'workattribute';                   // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $field;                           // string(200)  not_null
    var $type;                            // string(20)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Workattribute',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
}

?>
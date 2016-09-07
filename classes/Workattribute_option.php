<?php
/**
 * Table Definition for workattribute_option
 */
require_once 'DB/DataObject.php';

class Workattribute_option extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'workattribute_option';            // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $workattribute_id;                // int(11)  not_null
    var $title;                           // string(200)  not_null
    var $value;                           // string(100)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Workattribute_option',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function getCutTitle()
    {
        if (strlen($this->title) > 80) {
            return substr($this->title, 0, 80) . "...";
        } else {
            return $this->title;
        }
    }
}

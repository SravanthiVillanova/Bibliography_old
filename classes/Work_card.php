<?php
/**
 * Table Definition for work_card
 */
require_once 'DB/DataObject.php';

class Work_card extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'work_card';                       // table name
    var $work_id;                         // int(11)  not_null primary_key
    var $card_id;                         // int(11)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Work_card',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

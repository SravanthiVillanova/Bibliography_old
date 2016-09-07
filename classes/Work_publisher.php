<?php
/**
 * Table Definition for work_publisher
 */
require_once 'DB/DataObject.php';

class Work_publisher extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'work_publisher';                  // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $work_id;                         // int(11)  not_null multiple_key
    var $publisher_id;                    // int(11)  not_null multiple_key
    var $location_id;                     // int(11)  multiple_key
    var $publish_month;                   // int(11)  
    var $publish_year;                    // int(4)  not_null
    var $publish_month_end;               // int(11)  
    var $publish_year_end;                // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Work_publisher',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

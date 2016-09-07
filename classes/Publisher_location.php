<?php
/**
 * Table Definition for publisher_location
 */
require_once 'DB/DataObject.php';

class Publisher_location extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'publisher_location';              // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $publisher_id;                    // int(11)  not_null multiple_key
    var $location;                        // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Publisher_location',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function getWorkCount()
    {
        $work = new Work();
        $sql = "SELECT COUNT(id) as cnt FROM work_publisher WHERE publisher_id = '$this->publisher_id' AND location_id = '$this->id'";
        $work->query($sql);
        $work->fetch();
        return $work->cnt;
    }
}
